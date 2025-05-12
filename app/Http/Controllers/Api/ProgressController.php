<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProgressStoreRequest;
use App\Models\UserProgress;

class ProgressController extends Controller
{
    public function store(ProgressStoreRequest $request)
    {
        \Log::info('Authenticated user ID:', ['id' => auth()->id()]);

        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'story_id' => $request->input('story_id'),
            ],
            [
                'chapter_id' => $request->input('chapter_id'),
                'choices_made' => $request->input('choices_made', []),
            ]
        );

        return response()->json([
            'success' => true,
            'data' => $progress,
        ]);
    }
}