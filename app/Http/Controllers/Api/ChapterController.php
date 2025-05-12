<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Story; // N'oubliez pas d'importer le modèle Story
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    use ApiResponse;

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
    public function show($id): JsonResponse
    {
        try {
            $chapter = Chapter::with('choices')->findOrFail($id);
            return $this->success([
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
            ]);
        } catch (\Exception $e) {
            return $this->error('Erreur lors du chargement du chapitre', 500);
        }
    }

    /**
     * Récupère le premier chapitre d'une histoire.
     */
    public function firstChapter($storyId): JsonResponse
    {
        try {
            // Vérifions d'abord si l'histoire existe
            $story = Story::findOrFail($storyId);
            
            \Log::info('Fetching first chapter for story: ' . $storyId);
            
            // Recherchons le premier chapitre de cette histoire
            $chapter = Chapter::where('story_id', $storyId)
                ->orderBy('chapter_number')
                ->with('choices')
                ->firstOrFail(); // Utilisons firstOrFail au lieu de first

            if (!$chapter) {
                \Log::error('No chapter found for story: ' . $storyId);
                return $this->error('Aucun chapitre trouvé pour cette histoire', 404);
            }

            \Log::info('Chapter found:', ['chapter' => $chapter->toArray()]);

            // Retournons les données du chapitre avec ses choix
            return $this->success([
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
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Story or Chapter not found: ' . $e->getMessage());
            return $this->error('Histoire ou chapitre non trouvé', 404);
        } catch (\Exception $e) {
            \Log::error('Error in firstChapter: ' . $e->getMessage());
            return $this->error('Erreur lors du chargement du premier chapitre', 500);
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
