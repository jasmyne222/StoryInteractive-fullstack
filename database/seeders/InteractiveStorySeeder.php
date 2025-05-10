<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Choice;

class InteractiveStorySeeder extends Seeder
{
    public function run(): void
    {
        $story = Story::create([
            'title' => 'Le date parfait (ou presque)',
            'summary' => 'Tu as matché avec quelqu’un. À toi de faire les bons choix pour que tout se passe bien...',
        ]);

        $chapter1 = Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 1,
            'content' => 'Tu arrives au café. Ton date est déjà là. Tu fais quoi ?',
        ]);

        $chapter2 = Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 2,
            'content' => 'Tu complimentes son sourire. Il/elle te remercie, l’ambiance est légère.',
        ]);

        $chapter3 = Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 3,
            'content' => 'Tu regardes ton téléphone. Ton date semble déçu.',
        ]);

        Choice::create([
            'chapter_id' => $chapter1->id,
            'text' => 'Tu complimentes son sourire.',
            'next_chapter_id' => $chapter2->id,
        ]);

        Choice::create([
            'chapter_id' => $chapter1->id,
            'text' => 'Tu regardes ton téléphone.',
            'next_chapter_id' => $chapter3->id,
        ]);
    }
}
