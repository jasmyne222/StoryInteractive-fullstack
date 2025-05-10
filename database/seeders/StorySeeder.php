<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Choice;

class StorySeeder extends Seeder
{
    public function run(): void
    {
        // Créer une histoire
        $story = Story::create([
            'title' => 'Réussir un date',
            'summary' => 'Une soirée pleine de décisions… sauras-tu faire les bons choix ?',
        ]);

        // Créer les chapitres
        $chapters = [
            1 => Chapter::create([
                'story_id' => $story->id,
                'chapter_number' => 1,
                'content' => 'Tu arrives au café. La personne t’attend déjà, souriante.'
            ]),
            2 => Chapter::create([
                'story_id' => $story->id,
                'chapter_number' => 2,
                'content' => 'Tu commandes un café. Silence gênant.'
            ]),
            3 => Chapter::create([
                'story_id' => $story->id,
                'chapter_number' => 3,
                'content' => 'Tu lui dis qu\'elle a un très beau sourire. Elle rougit.'
            ]),
            4 => Chapter::create([
                'story_id' => $story->id,
                'chapter_number' => 4,
                'content' => 'Elle rit à ta blague. Le date se détend.'
            ]),
            5 => Chapter::create([
                'story_id' => $story->id,
                'chapter_number' => 5,
                'content' => 'Elle regarde son téléphone, mal à l’aise.'
            ]),
            6 => Chapter::create([
                'story_id' => $story->id,
                'chapter_number' => 6,
                'content' => 'Vous sortez marcher. Le courant passe bien.'
            ]),
            7 => Chapter::create([
                'story_id' => $story->id,
                'chapter_number' => 7,
                'content' => '“Je suis pas encore prêt pour une relation…” dit-elle.'
            ]),
        ];

        // Créer les choix
        Choice::insert([
            ['chapter_id' => $chapters[1]->id, 'text' => 'Tu commandes un café', 'next_chapter_id' => $chapters[2]->id],
            ['chapter_id' => $chapters[1]->id, 'text' => 'Tu lui fais un compliment', 'next_chapter_id' => $chapters[3]->id],

            ['chapter_id' => $chapters[2]->id, 'text' => 'Tu brises la glace', 'next_chapter_id' => $chapters[4]->id],
            ['chapter_id' => $chapters[2]->id, 'text' => 'Tu restes silencieux…', 'next_chapter_id' => $chapters[5]->id],

            ['chapter_id' => $chapters[3]->id, 'text' => 'Tu proposes une balade', 'next_chapter_id' => $chapters[6]->id],
            ['chapter_id' => $chapters[3]->id, 'text' => 'Tu parles de ton ex…', 'next_chapter_id' => $chapters[7]->id],

            ['chapter_id' => $chapters[4]->id, 'text' => 'Tu proposes un dessert', 'next_chapter_id' => $chapters[6]->id],
        ]);
    }
}
