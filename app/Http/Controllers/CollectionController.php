<?php

namespace App\Http\Controllers;

use App\Models\EbookProgram;
use App\Models\NewArrival;
use App\Models\OpenAccessResource;
use Illuminate\Http\Request;
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
}