<?php

namespace App\Http\Controllers;

use App\Services\LisaAssistant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LisaController extends Controller
{
    public function message(Request $request, LisaAssistant $assistant): JsonResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        return response()->json(
            $assistant->reply($data['message'])
        );
    }
}
