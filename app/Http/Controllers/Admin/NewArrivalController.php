<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewArrival;
use App\Support\DatabaseMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class NewArrivalController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));

        $availabilityStatus = $request->input(
            'availability_status'
        );

        $arrivals = NewArrival::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where(
                            'accession_number',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'title',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'author',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'category',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'description',
                            'like',
                            "%{$search}%"
                        );
                });
            })
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
        DatabaseMedia::ensureBlobColumns([
            'new_arrivals',
        ]);

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
        DatabaseMedia::ensureBlobColumns([
            'new_arrivals',
        ]);

        $validated = $request->validate(
            $this->validationRules($newArrival),
            $this->validationMessages()
        );

        $data = $this->prepareArrivalData(
            $request,
            $validated,
            $newArrival
        );

        $newArrival->update($data);

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
        $newArrival->delete();

        return redirect()
            ->route('admin.new-arrivals.index')
            ->with(
                'success',
                'New arrival deleted successfully.'
            );
    }

    private function validationRules(
        ?NewArrival $newArrival = null
    ): array {
        return [
            'accession_number' => [
                'required',
                'string',
                'max:100',

                Rule::unique(
                    'new_arrivals',
                    'accession_number'
                )->ignore($newArrival?->id),
            ],

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
            'accession_number.required' =>
                'The accession number is required.',

            'accession_number.unique' =>
                'This accession number is already assigned to another material.',

            'accession_number.max' =>
                'The accession number must not exceed 100 characters.',

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
            'accession_number' => strtoupper(
                trim($validated['accession_number'])
            ),

            'title' => trim($validated['title']),

            'author' => filled(
                $validated['author'] ?? null
            )
                ? trim($validated['author'])
                : null,

            'category' => filled(
                $validated['category'] ?? null
            )
                ? trim($validated['category'])
                : null,

            'description' => filled(
                $validated['description'] ?? null
            )
                ? trim($validated['description'])
                : null,

            'availability_status' =>
                $validated['availability_status'],

            'arrival_date' =>
                $validated['arrival_date'],
        ];

        if ($request->hasFile('image_file')) {
            $data['image'] = DatabaseMedia::store(
                $request->file('image_file')
            );
        } elseif (filled($validated['image_url'] ?? null)) {
            $data['image'] = trim(
                $validated['image_url']
            );
        } elseif (!$newArrival) {
            $data['image'] = null;
        }

        return $data;
    }
}