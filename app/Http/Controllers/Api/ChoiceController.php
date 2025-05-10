<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Choice;

class ChoiceController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'chapter_id' => 'required|exists:chapters,id',
        'text' => 'required|string',
        'next_chapter_id' => 'nullable|exists:chapters,id',
    ]);

    $choice = Choice::create($validated);

    return response()->json($choice, 201);
}
}


