<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserProgress;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function store(Request $request)
    {
        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'story_id' => $request->story_id
            ],
            [
                'chapter_id' => $request->chapter_id,
                'stats' => $request->stats ?? [],
                'choices_made' => $request->choices_made ?? []
            ]
        );

        return response()->json([
            'success' => true,
            'data' => $progress
        ]);
    }

    public function show()
    {
        $progress = UserProgress::where('user_id', Auth::id())
            ->with(['chapter', 'story'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $progress
        ]);
    }
}