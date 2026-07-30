<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class ClearCompiledViews
{
    public function handle(Request $request, Closure $next): Response
    {
        File::delete(File::glob(storage_path('framework/views/*.php')));

        return $next($request);
    }
}
