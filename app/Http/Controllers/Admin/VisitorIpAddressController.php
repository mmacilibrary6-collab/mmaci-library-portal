<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class VisitorIpAddressController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $date = trim((string) $request->string('date'));
        $method = strtoupper(trim((string) $request->string('method')));
        $status = trim((string) $request->string('status'));

        $logs = VisitorLog::query()
            ->with('user:id,name,email')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('ip_address', 'like', "%{$search}%")
                        ->orWhere('url', 'like', "%{$search}%")
                        ->orWhere('method', 'like', "%{$search}%")
                        ->orWhere('user_agent', 'like', "%{$search}%")
                        ->orWhere('referrer', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($date !== '', fn ($query) => $query->whereDate('created_at', $date))
            ->when($method !== '', fn ($query) => $query->where('method', $method))
            ->when($status !== '', fn ($query) => $query->where('status_code', (int) $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $countsByIp = $this->recentCountsByIp($logs->getCollection());

        $logs->getCollection()->transform(function (VisitorLog $log) use ($countsByIp) {
            $log->security_label = $this->securityLabel($log, (int) ($countsByIp[$log->ip_address] ?? 0));

            return $log;
        });

        $summary = Cache::remember('visitor-ip-summary', now()->addSeconds(60), function (): array {
            return VisitorLog::query()
                ->selectRaw('COUNT(*) as total')
                ->selectRaw('SUM(CASE WHEN DATE(created_at) = ? THEN 1 ELSE 0 END) as today', [today()->toDateString()])
                ->selectRaw('SUM(CASE WHEN status_code IN (401, 403, 404, 429) THEN 1 ELSE 0 END) as suspicious')
                ->first()
                ->toArray();
        });

        $summary = [
            'total' => (int) ($summary['total'] ?? 0),
            'today' => (int) ($summary['today'] ?? 0),
            'suspicious' => (int) ($summary['suspicious'] ?? 0),
        ];

        return view('admin.visitor-ip-address.index', compact(
            'logs',
            'search',
            'date',
            'method',
            'status',
            'summary'
        ));
    }

    public function prune(Request $request): RedirectResponse
    {
        $days = max(1, (int) $request->integer('days', config('security.visitor_log_retention_days', 90)));
        $deleted = VisitorLog::where('created_at', '<', now()->subDays($days))->delete();
        Cache::forget('visitor-ip-summary');

        return redirect()
            ->route('admin.visitor-ip-address.index')
            ->with('success', "{$deleted} old visitor logs deleted successfully.");
    }

    protected function recentCountsByIp(Collection $logs): array
    {
        $ips = $logs->pluck('ip_address')->filter()->unique()->values();

        if ($ips->isEmpty()) {
            return [];
        }

        return VisitorLog::query()
            ->select('ip_address', DB::raw('COUNT(*) as total'))
            ->whereIn('ip_address', $ips)
            ->where('created_at', '>=', now()->subHours(24))
            ->groupBy('ip_address')
            ->pluck('total', 'ip_address')
            ->map(fn ($value) => (int) $value)
            ->all();
    }

    protected function securityLabel(VisitorLog $log, int $recentCount): string
    {
        if ((int) $log->status_code === 429) {
            return 'Rate Limited';
        }

        $attackPaths = ['.env', '/wp-admin', '/phpmyadmin', '/.git', '/admin.php', '/config.php'];
        $url = strtolower((string) $log->url);

        if (in_array((int) $log->status_code, [401, 403, 404], true) && str_contains($url, '/')) {
            foreach ($attackPaths as $attackPath) {
                if (str_contains($url, $attackPath)) {
                    return 'Suspicious Pattern';
                }
            }
        }

        if ($recentCount >= 120) {
            return 'Suspicious Pattern';
        }

        if ($recentCount >= 40 || in_array((int) $log->status_code, [401, 403, 404], true)) {
            return 'High Activity';
        }

        return 'Normal';
    }
}
