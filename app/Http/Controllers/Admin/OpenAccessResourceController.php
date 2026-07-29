<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpenAccessResource;
use App\Support\DatabaseMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OpenAccessResourceController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim(
            (string) $request->input('search')
        );

        $status = $request->input('status');

        $resources = OpenAccessResource::query()
            ->when(
                $search !== '',
                function ($query) use ($search) {
                    $query->where(
                        function ($subQuery) use ($search) {
                            $subQuery
                                ->where(
                                    'title',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'description',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            )
            ->when(
                $status === 'active',
                fn ($query) => $query->where(
                    'is_active',
                    true
                )
            )
            ->when(
                $status === 'inactive',
                fn ($query) => $query->where(
                    'is_active',
                    false
                )
            )
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(12)
            ->withQueryString();

        return view(
            'admin.open-access-resources.list',
            compact('resources')
        );
    }

    public function create(): View
    {
        return view(
            'admin.open-access-resources.create'
        );
    }

    public function store(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate(
            $this->rules(true),
            $this->messages()
        );

        $imagePath = null;

        if ($request->hasFile('image_file')) {
            $imagePath = DatabaseMedia::store(
                $request->file('image_file')
            );
        } elseif (
            filled($validated['image_url'] ?? null)
        ) {
            $imagePath = trim(
                $validated['image_url']
            );
        }

        OpenAccessResource::create([
            'title' => trim(
                $validated['title']
            ),

            'description' => filled(
                $validated['description'] ?? null
            )
                ? trim($validated['description'])
                : null,

            'website_url' => trim(
                $validated['website_url']
            ),

            'image' => $imagePath,

            'sort_order' => (int) (
                $validated['sort_order'] ?? 0
            ),

            'is_active' => $request->boolean(
                'is_active'
            ),
        ]);

        return redirect()
            ->route(
                'admin.open-access-resources.index'
            )
            ->with(
                'success',
                'Open access resource added successfully.'
            );
    }

    public function edit(
        OpenAccessResource $openAccessResource
    ): View {
        return view(
            'admin.open-access-resources.edit',
            compact('openAccessResource')
        );
    }

    public function update(
        Request $request,
        OpenAccessResource $openAccessResource
    ): RedirectResponse {
        $validated = $request->validate(
            $this->rules(false),
            $this->messages()
        );

        $data = [
            'title' => trim(
                $validated['title']
            ),

            'description' => filled(
                $validated['description'] ?? null
            )
                ? trim($validated['description'])
                : null,

            'website_url' => trim(
                $validated['website_url']
            ),

            'sort_order' => (int) (
                $validated['sort_order'] ?? 0
            ),

            'is_active' => $request->boolean(
                'is_active'
            ),
        ];

        if ($request->hasFile('image_file')) {
            $data['image'] = $request
                ->file('image_file')
                ? DatabaseMedia::store($request->file('image_file'))
                : null;
        } elseif (
            filled($validated['image_url'] ?? null)
        ) {
            $data['image'] = trim(
                $validated['image_url']
            );
        }

        $openAccessResource->update($data);

        return redirect()
            ->route(
                'admin.open-access-resources.index'
            )
            ->with(
                'success',
                'Open access resource updated successfully.'
            );
    }

    public function destroy(
        OpenAccessResource $openAccessResource
    ): RedirectResponse {
        $openAccessResource->delete();

        return redirect()
            ->route(
                'admin.open-access-resources.index'
            )
            ->with(
                'success',
                'Open access resource deleted successfully.'
            );
    }

    private function rules(
        bool $creating
    ): array {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'website_url' => [
                'required',
                'url:http,https',
                'max:2048',
            ],

            'image_file' => [
                $creating
                    ? 'nullable'
                    : 'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'image_url' => [
                'nullable',
                'url:http,https',
                'max:2048',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
                'max:9999',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    private function messages(): array
    {
        return [
            'title.required' =>
                'The resource title is required.',

            'website_url.required' =>
                'The website link is required.',

            'website_url.url' =>
                'Enter a valid website link beginning with http:// or https://.',

            'image_file.image' =>
                'The uploaded file must be an image.',

            'image_file.mimes' =>
                'The image must be JPG, JPEG, PNG, or WEBP.',

            'image_file.max' =>
                'The image must not exceed 5 MB.',

            'image_url.url' =>
                'Enter a valid external image link.',

            'sort_order.integer' =>
                'The sort order must be a whole number.',
        ];
    }

}
