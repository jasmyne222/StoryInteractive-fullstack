<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserProgress;

class ProgressController extends Controller
{
    public function store(Request $request)
    {
        $progress = UserProgress::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'chapter_id' => $request->chapter_id,
                'story_id' => $request->story_id,
            ]
        );

        return response()->json($progress);
    }

    public function show()
    {
        $progress = UserProgress::where('user_id', auth()->id())
            ->with(['chapter', 'story'])
            ->first();

        return response()->json($progress);
    }
}