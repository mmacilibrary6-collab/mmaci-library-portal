<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewArrival;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class NewArrivalController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $resourceType = $request->input('resource_type');
        $availabilityStatus = $request->input(
            'availability_status'
        );

        $arrivals = NewArrival::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when(
                filled($resourceType),
                fn ($query) => $query->where(
                    'resource_type',
                    $resourceType
                )
            )
            ->when(
                filled($availabilityStatus),
                fn ($query) => $query->where(
                    'availability_status',
                    $availabilityStatus
                )
            )
            ->orderByDesc('arrival_date')
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view(
            'admin.arrivals.list',
            compact('arrivals')
        );
    }

    public function create(): View
    {
        return view('admin.arrivals.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            $this->validationRules(),
            $this->validationMessages()
        );

        $data = $this->prepareArrivalData(
            $request,
            $validated
        );

        NewArrival::create($data);

        return redirect()
            ->route('admin.new-arrivals.index')
            ->with(
                'success',
                'New arrival added successfully.'
            );
    }

    public function edit(NewArrival $newArrival): View
    {
        return view(
            'admin.arrivals.edit',
            compact('newArrival')
        );
    }

    public function update(
        Request $request,
        NewArrival $newArrival
    ): RedirectResponse {
        $validated = $request->validate(
            $this->validationRules(),
            $this->validationMessages()
        );

        $oldImage = $newArrival->image;

        $data = $this->prepareArrivalData(
            $request,
            $validated,
            $newArrival
        );

        $newArrival->update($data);

        if (
            $request->hasFile('image_file') &&
            $this->isLocalImage($oldImage)
        ) {
            Storage::disk('public')->delete(
                $this->normalizeLocalImagePath($oldImage)
            );
        }

        return redirect()
            ->route('admin.new-arrivals.index')
            ->with(
                'success',
                'New arrival updated successfully.'
            );
    }

    public function destroy(
        NewArrival $newArrival
    ): RedirectResponse {
        if ($this->isLocalImage($newArrival->image)) {
            Storage::disk('public')->delete(
                $this->normalizeLocalImagePath($newArrival->image)
            );
        }

        $newArrival->delete();

        return redirect()
            ->route('admin.new-arrivals.index')
            ->with(
                'success',
                'New arrival deleted successfully.'
            );
    }

    private function validationRules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'author' => [
                'nullable',
                'string',
                'max:255',
            ],

            'category' => [
                'nullable',
                'string',
                'max:255',
            ],

            'arrival_date' => [
                'required',
                'date',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'resource_type' => [
                'required',
                'in:printed,ebook',
            ],

            'availability_status' => [
                'required',
                'in:available,unavailable',
            ],

            'image_file' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'image_url' => [
                'nullable',
                'url',
                'max:2048',
            ],
        ];
    }

    private function validationMessages(): array
    {
        return [
            'title.required' =>
                'The title is required.',

            'title.max' =>
                'The title must not exceed 255 characters.',

            'author.max' =>
                'The author name must not exceed 255 characters.',

            'category.max' =>
                'The category must not exceed 255 characters.',

            'arrival_date.required' =>
                'Please specify the date of arrival.',

            'arrival_date.date' =>
                'The date of arrival must be a valid date.',

            'resource_type.required' =>
                'Please select a resource type.',

            'resource_type.in' =>
                'The selected resource type is invalid.',

            'availability_status.required' =>
                'Please select an availability status.',

            'availability_status.in' =>
                'The selected availability status is invalid.',

            'image_file.image' =>
                'The uploaded file must be an image.',

            'image_file.mimes' =>
                'The cover image must be a JPG, JPEG, PNG, or WEBP file.',

            'image_file.max' =>
                'The cover image must not exceed 5 MB.',

            'image_url.url' =>
                'Enter a valid image URL.',

            'image_url.max' =>
                'The image URL must not exceed 2,048 characters.',
        ];
    }

    private function prepareArrivalData(
        Request $request,
        array $validated,
        ?NewArrival $newArrival = null
    ): array {
        $data = [
            'title' => trim($validated['title']),

            'author' => filled($validated['author'] ?? null)
                ? trim($validated['author'])
                : null,

            'category' => filled($validated['category'] ?? null)
                ? trim($validated['category'])
                : null,

            'description' => filled(
                $validated['description'] ?? null
            )
                ? trim($validated['description'])
                : null,

            'resource_type' =>
                $validated['resource_type'],

            'availability_status' =>
                $validated['availability_status'],

            'arrival_date' =>
                $validated['arrival_date'],
        ];

        /*
         * An uploaded image takes priority over an external URL.
         */
        if ($request->hasFile('image_file')) {
            $data['image'] = $request
                ->file('image_file')
                ->store('new-arrivals', 'public');
        } elseif (filled($validated['image_url'] ?? null)) {
            $data['image'] = trim(
                $validated['image_url']
            );

            if (
                $newArrival &&
                $this->isLocalImage($newArrival->image)
            ) {
                Storage::disk('public')->delete(
                    $newArrival->image
                );
            }
        } elseif (!$newArrival) {
            $data['image'] = null;
        }

        return $data;
    }

    private function isLocalImage(?string $image): bool
    {
        if (blank($image)) {
            return false;
        }

        return !str_starts_with($image, 'http://') &&
            !str_starts_with($image, 'https://');
    }

    private function normalizeLocalImagePath(?string $image): string
    {
        $image = trim((string) $image);

        if (str_starts_with($image, 'storage/')) {
            $image = substr($image, 8);
        }

        return ltrim($image, '/');
    }
}
