<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chapter;

class ChapterController extends Controller
{
    /**
     * Retourne tous les chapitres (optionnel si tu veux afficher une liste dans le back).
     */
    public function index()
    {
        return response()->json(Chapter::all());
    }

    /**
     * Enregistre un nouveau chapitre.
     */
    public function store(Request $request)
    {
        $chapter = Chapter::create($request->all());
        return response()->json($chapter, 201);
    }

    /**
     * Affiche un chapitre avec ses choix.
     */
    public function show($id)
    {
        try {
            \Log::info('Loading chapter: ' . $id); // Debug log
            
            $chapter = Chapter::with('choices')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $chapter->id,
                    'content' => $chapter->content,
                    'chapter_number' => $chapter->chapter_number,
                    'choices' => $chapter->choices->map(function($choice) {
                        return [
                            'id' => $choice->id,
                            'text' => $choice->text,
                            'next_chapter_id' => $choice->next_chapter_id
                        ];
                    })
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in show: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading chapter: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupère le premier chapitre d'une histoire.
     */
    public function firstChapter($storyId)
    {
        try {
            \Log::info('Loading first chapter for story: ' . $storyId);
            
            $chapter = Chapter::where('story_id', $storyId)
                             ->orderBy('chapter_number')
                             ->with('choices') // Eager load choices
                             ->first();

            if (!$chapter) {
                \Log::warning('No chapter found for story: ' . $storyId);
                return response()->json([
                    'success' => false,
                    'message' => 'No chapters found for this story'
                ], 404);
            }

            \Log::info('Chapter found:', ['id' => $chapter->id]);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $chapter->id,
                    'content' => $chapter->content,
                    'chapter_number' => $chapter->chapter_number,
                    'choices' => $chapter->choices->map(function($choice) {
                        return [
                            'id' => $choice->id,
                            'text' => $choice->text,
                            'next_chapter_id' => $choice->next_chapter_id
                        ];
                    })
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in firstChapter: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load chapter'
            ], 500);
        }
    }

    /**
     * Met à jour un chapitre.
     */
    public function update(Request $request, string $id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->update($request->all());
        return response()->json($chapter);
    }

    /**
     * Supprime un chapitre.
     */
    public function destroy(string $id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->delete();
        return response()->json(null, 204);
    }
}
