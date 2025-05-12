<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProgressStoreRequest;
use App\Models\UserProgress;

class ProgressController extends Controller
{
    public function store(ProgressStoreRequest $request)
    {
        // Les données sont déjà validées ici
        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'story_id' => $request->validated('story_id')
            ],
            [
                'chapter_id' => $request->validated('chapter_id'),
                'choices_made' => $request->validated('choices_made', [])
            ]
        );

        return response()->json([
            'success' => true,
            'data' => $progress
        ]);
    }
}