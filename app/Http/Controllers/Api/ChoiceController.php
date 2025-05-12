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

    public function index($chapterId)
    {
        try {
            $choices = Choice::where('chapter_id', $chapterId)->get();

            return response()->json([
                'success' => true,
                'data' => $choices,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching choices for chapter ' . $chapterId . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des choix.',
            ], 500);
        }
    }
}


