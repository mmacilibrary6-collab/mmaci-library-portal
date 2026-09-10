<?php

namespace App\Http\Controllers\Admin;

use App\Models\ReferenceResource;

class ReferenceResourceController extends OpenAccessResourceController
{
    protected string $resourceModel = ReferenceResource::class;
    protected string $resourceRoute = 'admin.reference-resources';
    protected string $resourceTitle = 'Reference & Research Assistance';
}
