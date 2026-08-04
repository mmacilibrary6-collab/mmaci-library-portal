<?php

namespace App\Http\Controllers;

use App\Models\EbookProgram;
use App\Models\DonatedBook;
use App\Models\NewArrival;
use App\Models\PeriodicalProgram;
use App\Models\OpenAccessResource;
use App\Models\ThesisProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function printed(Request $request): View
    {
        $query = NewArrival::query()
            ->where('resource_type', 'printed')
            ->where('availability_status', 'available');

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));

            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where(
                'category',
                $request->input('category')
            );
        }

        $printedBooks = $query
            ->orderByDesc('arrival_date')
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        /*
         * Complete New Arrivals list displayed on the
         * dynamic New Arrivals section.
         */
        $newArrivals = NewArrival::query()
            ->where('resource_type', 'printed')
            ->where('availability_status', 'available')
            ->orderByDesc('arrival_date')
            ->orderByDesc('created_at')
            ->get();

        $categories = NewArrival::query()
            ->where('resource_type', 'printed')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('collection.printed', compact(
            'printedBooks',
            'newArrivals',
            'categories'
        ));
    }

    public function ebooks(): View
    {
        $programs = EbookProgram::query()
            ->where('status', true)
            ->with([
                'folders' => function ($query) {
                    $query
                        ->where('status', true)
                        ->orderBy('sort_order')
                        ->orderBy('title');
                },
            ])
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view(
            'collection.ebooks',
            compact('programs')
        );
    }

    public function theses(): View
    {
        $programs = ThesisProgram::query()
            ->where('status', true)
            ->with([
                'folders' => function ($query) {
                    $query
                        ->where('status', true)
                        ->orderBy('sort_order')
                        ->orderBy('title');
                },
            ])
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('collection.theses', compact('programs'));
    }

    public function openAccess(): View
    {
        $resources = OpenAccessResource::query()
            ->active()
            ->ordered()
            ->get();

        return view(
            'collection.open-access',
            compact('resources')
        );
    }

    public function subscribedDatabase(): View
    {
        return view('collection.subscribed-database', [
            'accessUrl' => 'https://login.ebsco.com/?custId=ns329417&requestIdentifier=f0f7121c-4505-4194-91d2-4a89eb9b86e0&acrValues=uid,cpid&ui_locales&redirect_uri=https://logon.ebsco.zone/api/dispatcher/continue/prompted?state=MGQ5YzAxY2FkODhkNGUyMmFiMjEyNGYxNjQzYjIxMWQ=&authRequest=eyJraWQiOiIxNzY5MTEwMjQ0MDQ3IiwiYWxnIjoiUlMyNTYifQ.eyJpc3MiOiJodHRwczovL2F1dGguZWJzY28uem9uZS9hcGkvZGlzcGF0Y2hlciIsImF1dGhSZXF1ZXN0Ijp7ImxvZ2luX2hpbnQiOiJjdXN0SWQ6bnMzMjk0MTciLCJhY3JfdmFsdWVzIjoidWlkIGNwaWQiLCJzY29wZSI6Im9wZW5pZCBlbWFpbCBhZmZpbGlhdGlvbiIsInJlc3BvbnNlX3R5cGUiOiJjb2RlIiwicmVkaXJlY3RfdXJpIjoiaHR0cHM6Ly9zZWFyY2guZWJzY29ob3N0LmNvbS93ZWJhdXRoL1Byb21wdGVkQ2FsbGJhY2suYXNweCIsInN0YXRlIjoiQXhWbm1VY0ZHSE5ZNVpuZGNsVGVvZFZ6VTlkZThjam84N0R5V3RtTFlPX1UtakE3SnczcWdvdVVLeW1nbll2cVc3ZVlidHF5UDYyLXZBVEtrLTVaZUFYMHBWYkxyRFlLYi1LQ0VVVUlVZ1NkcG12THJ5OTBUNzJuaGNma1JWbGt1Sl9Ec2taWXBidGlRSGdXNS15ekJBSWxoU0xtaGl2VXpkQWFhekpkd2hQMzVBNXVFelVuZWs3cnNiTmFaTWZBd2RMRzlsaGZxSWsyVjZvSFEyVU5NeUxlSTdDMXd0WHhXS2VqQnVZVEdkZUFjZ2pIaTZUWTd4Q2tPNHJIYWhHc08tcE42c1A5UmJ2cTNldkNoR0VBMXFNWHJrYTBScnNWdndmdXVlV1hOeFZSZkVKMExQTm5la3pmWktESUdrQjdnU2ZPWnl2bU0wSmN1SndPanljRkMxaHU1cXJ5X0xJaUVTNTNiSDljMGhEcU5pYnlvTXJONzJiUWRIRHBjVTVaSWViaUxHclZPMmg0TXRQbGpOaXR4dnVpYnNsWmFGYk82N1JCTm1qaGpldXB3ZklaaW9RbDl2SzhIQ3pkRkgyc0hqOHJET0l4eEMtNDFUbEt4NjZ2IiwiY2xpZW50X2lkIjoiYXdneWNJeDU3TXJ3bkRRNWg0VWU2eUNWRVAwcjVNdDkifSwiaWF0IjoxNzg1Mzk1MTExLCJqdGkiOiIwMmQ2ZjJkYi1kNGViLTQwYzgtOGQ2NS03MzNjZGZmMjg4MjIiLCJyZXFJZCI6ImYwZjcxMjFjLTQ1MDUtNDE5NC05MWQyLTRhODllYjliODZlMCJ9.OrWXcvroAVbC6-uTQpwvePfvbrHpTFtkRKLOgnWaSUqIN1vibq22ZOTv-QTxWzajWzuY9Q5hLyeVPGu0SRuFmE1NJFO9BMeP8kc11D-jO9IIZUhMssOMmwXAMroRL0uM2kBQ40ELwclKTy7U6_OC8RYPdr28D1bDS-bD5tWF38OvwgBvDDXiUY1NOHMkTORR3RKbVg7kqE2B4q2MHL3FjiGyba5wHJGXPfT4fiVTa_k7BtXo4T8bvRUm9-peFIgHDaN0lvKXg_UvSLW6nZcNNP2dUof8aVCcRe0k00_C_VrmlgEfBKtnfCnWD8zCx78ptXW5dumwq-l98T7Aex4QgA',
        ]);
    }

    public function donatedBooks(): View
    {
        $books = DonatedBook::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('collection.donated-books', compact('books'));
    }

    public function periodicals(Request $request): View
    {
        $hasFolderCategory = Schema::hasColumn('periodical_folders', 'category');
        $selectedCategory = $request->input('category');

        $programs = PeriodicalProgram::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->with([
                'folders' => function ($query) use ($hasFolderCategory, $selectedCategory) {
                    $query->where('status', true);

                    if ($hasFolderCategory && filled($selectedCategory)) {
                        $query->where('category', $selectedCategory);
                    }

                    if ($hasFolderCategory) {
                        $query->orderBy('category');
                    }

                    $query->orderBy('sort_order')->orderBy('title');
                },
            ])
            ->get();

        if (filled($selectedCategory)) {
            $programs = $programs
                ->map(function ($program) use ($selectedCategory) {
                    $program->setRelation(
                        'folders',
                        $program->folders->filter(fn ($folder) => $folder->category === $selectedCategory)->values()
                    );

                    return $program;
                })
                ->filter(fn ($program) => $program->folders->isNotEmpty())
                ->values();
        }

        return view('collection.periodicals', compact('programs', 'selectedCategory'));
    }
}
