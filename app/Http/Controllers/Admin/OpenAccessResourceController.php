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
    protected string $resourceModel = OpenAccessResource::class;
    protected string $resourceRoute = 'admin.open-access-resources';
    protected string $resourceTitle = 'Open Access Resources';

    private function resourceView(string $view, array $data = []): View
    {
        return view($view, array_merge($data, [
            'resourceRoute' => $this->resourceRoute,
            'resourceTitle' => $this->resourceTitle,
        ]));
    }

    public function index(Request $request): View
    {
        $search = trim(
            (string) $request->input('search')
        );

        $status = $request->input('status');

        $resources = $this->resourceModel::query()
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
            ->orderBy('title', 'asc')
            ->paginate(12)
            ->withQueryString();

        return $this->resourceView(
            'admin.open-access-resources.list',
            compact('resources')
        );
    }

    public function create(): View
    {
        return $this->resourceView(
            'admin.open-access-resources.create'
        );
    }

    public function store(
        Request $request
    ): RedirectResponse {
        if ($this->resourceModel === OpenAccessResource::class) {
            DatabaseMedia::ensureBlobColumns(['open_access_resources']);
        }

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

        $this->resourceModel::create([
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

            'is_active' => $request->boolean(
                'is_active'
            ),
        ]);

        return redirect()
            ->route(
                $this->resourceRoute . '.index'
            )
            ->with(
                'success',
                'Resource added successfully.'
            );
    }

    public function edit(
        string $openAccessResource
    ): View {
        $openAccessResource = $this->resourceModel::findOrFail($openAccessResource);
        return $this->resourceView(
            'admin.open-access-resources.edit',
            compact('openAccessResource')
        );
    }

    public function update(
        Request $request,
        string $openAccessResource
    ): RedirectResponse {
        if ($this->resourceModel === OpenAccessResource::class) {
            DatabaseMedia::ensureBlobColumns(['open_access_resources']);
        }

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

        $openAccessResource = $this->resourceModel::findOrFail($openAccessResource);
        $openAccessResource->update($data);

        return redirect()
            ->route(
                $this->resourceRoute . '.index'
            )
            ->with(
                'success',
                'Resource updated successfully.'
            );
    }

    public function destroy(
        string $openAccessResource
    ): RedirectResponse {
        $openAccessResource = $this->resourceModel::findOrFail($openAccessResource);
        $openAccessResource->delete();

        return redirect()
            ->route(
                $this->resourceRoute . '.index'
            )
            ->with(
                'success',
                'Resource deleted successfully.'
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

        ];
    }

}
