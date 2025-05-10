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
    public function show(string $id)
    {
        $chapter = Chapter::with('choices')->findOrFail($id);
        return response()->json($chapter);
    }

    /**
     * Récupère le premier chapitre d'une histoire.
     */
    public function firstChapter($storyId)
    {
        $chapter = Chapter::where('story_id', $storyId)
                          ->orderBy('chapter_number')
                          ->with('choices')
                          ->first();

        if (!$chapter) {
            return response()->json(['message' => 'Chapitre de départ non trouvé'], 404);
        }

        return response()->json($chapter);
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
