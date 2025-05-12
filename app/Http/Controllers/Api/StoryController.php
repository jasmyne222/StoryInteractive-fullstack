<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StoryRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StoryController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            \Log::info('Attempting to fetch stories');
            
            $stories = Story::all();
            
            \Log::info('Found ' . $stories->count() . ' stories');

            $formattedStories = $stories->map(function($story) {
                return [
                    'id' => $story->id,
                    'title' => $story->title,
                    'description' => $story->summary,
                    'available' => true
                ];
            });

            \Log::info('Formatted stories data:', $formattedStories->toArray());

            return response()->json([
                'success' => true,
                'data' => $formattedStories
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in stories index: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading stories'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $story = Story::create([
            'title' => $request->input('title'),
            'summary' => $request->input('summary'),
        ]);
    
        return response()->json($story, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoryRequest $request, Story $story)
    {
        $story->update($request->validated());
        return response()->json($story);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Story $story)
    {
        $story->delete();
        return response()->json(null, 204);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $story = Story::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $story
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Story not found',
                'error' => 'NotFound'
            ], 404);
        }
    }
}
