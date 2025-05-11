<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Choice;
use Illuminate\Support\Facades\Log;

class StorySeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Starting StorySeeder');

            // Première histoire : Premier Rendez-vous
            $story1 = Story::create([
                'title' => 'Premier Rendez-vous',
                'summary' => 'Un premier rendez-vous qui pourrait mener à quelque chose de spécial... ou pas ! À toi de faire les bons choix.',
            ]);

            // Chapitres histoire 1
            $chapters1 = [
                'start' => Chapter::create([
                    'story_id' => $story1->id,
                    'chapter_number' => 1,
                    'content' => 'Tu arrives au café et aperçois ton rendez-vous assis à une table. Il/Elle te fait un signe de la main avec un sourire timide.'
                ]),
                
                // Branches positives
                'compliment' => Chapter::create([
                    'story_id' => $story1->id,
                    'chapter_number' => 2,
                    'content' => "Tu t'approches avec confiance et fais un compliment sur sa tenue. Ses yeux s'illuminent et l'atmosphère devient immédiatement plus détendue."
                ]),
                'discussion' => Chapter::create([
                    'story_id' => $story1->id,
                    'chapter_number' => 3,
                    'content' => "La conversation s'engage naturellement. Vous découvrez que vous avez beaucoup de points communs."
                ]),
                'promenade' => Chapter::create([
                    'story_id' => $story1->id,
                    'chapter_number' => 4,
                    'content' => "Tu proposes une promenade dans le parc voisin. Le coucher de soleil crée une atmosphère romantique."
                ]),
                
                // Branches neutres
                'cafe' => Chapter::create([
                    'story_id' => $story1->id,
                    'chapter_number' => 5,
                    'content' => "Tu commandes un café et la conversation démarre doucement. L'ambiance est agréable mais sans plus."
                ]),
                'smalltalk' => Chapter::create([
                    'story_id' => $story1->id,
                    'chapter_number' => 6,
                    'content' => "Vous parlez de sujets généraux : la météo, le travail, les loisirs. C'est cordial mais pas passionnant."
                ]),

                // Branches négatives
                'phone' => Chapter::create([
                    'story_id' => $story1->id,
                    'chapter_number' => 7,
                    'content' => "Tu regardes ton téléphone plusieurs fois. Ton rendez-vous semble légèrement agacé."
                ]),
                'ex' => Chapter::create([
                    'story_id' => $story1->id,
                    'chapter_number' => 8,
                    'content' => "Tu mentionnes ton ex dans la conversation. L'ambiance devient soudainement tendue."
                ]),

                // Fins
                'perfect_end' => Chapter::create([
                    'story_id' => $story1->id,
                    'chapter_number' => 9,
                    'content' => "FIN PARFAITE : La soirée se termine par un baiser sous les étoiles. Vous programmez déjà un second rendez-vous."
                ]),
                'good_end' => Chapter::create([
                    'story_id' => $story1->id,
                    'chapter_number' => 10,
                    'content' => "BONNE FIN : Le rendez-vous se termine agréablement. Vous échangez vos numéros avec le sourire."
                ]),
                'friend_end' => Chapter::create([
                    'story_id' => $story1->id,
                    'chapter_number' => 11,
                    'content' => "FIN AMICALE : Vous vous entendez bien, mais il n'y a pas d'étincelle romantique. Vous restez amis."
                ]),
                'bad_end' => Chapter::create([
                    'story_id' => $story1->id,
                    'chapter_number' => 12,
                    'content' => "MAUVAISE FIN : Le rendez-vous se termine maladroitement. Message non lu sur l'application de dating."
                ])
            ];

            // Choix histoire 1
            // Premier chapitre
            Choice::create([
                'chapter_id' => $chapters1['start']->id,
                'text' => 'Faire un compliment sur sa tenue',
                'next_chapter_id' => $chapters1['compliment']->id
            ]);
            Choice::create([
                'chapter_id' => $chapters1['start']->id,
                'text' => 'Commander directement un café',
                'next_chapter_id' => $chapters1['cafe']->id
            ]);
            Choice::create([
                'chapter_id' => $chapters1['start']->id,
                'text' => 'Regarder ton téléphone',
                'next_chapter_id' => $chapters1['phone']->id
            ]);

            // Branche positive
            Choice::create([
                'chapter_id' => $chapters1['compliment']->id,
                'text' => 'Continuer la conversation sur vos centres d\'intérêt',
                'next_chapter_id' => $chapters1['discussion']->id
            ]);
            Choice::create([
                'chapter_id' => $chapters1['compliment']->id,
                'text' => 'Parler de ton ex pour exemple',
                'next_chapter_id' => $chapters1['ex']->id
            ]);

            Choice::create([
                'chapter_id' => $chapters1['discussion']->id,
                'text' => 'Proposer une promenade romantique',
                'next_chapter_id' => $chapters1['promenade']->id
            ]);
            Choice::create([
                'chapter_id' => $chapters1['discussion']->id,
                'text' => 'Rester au café',
                'next_chapter_id' => $chapters1['smalltalk']->id
            ]);

            Choice::create([
                'chapter_id' => $chapters1['promenade']->id,
                'text' => 'Créer un moment romantique',
                'next_chapter_id' => $chapters1['perfect_end']->id
            ]);
            Choice::create([
                'chapter_id' => $chapters1['promenade']->id,
                'text' => 'Rester amical',
                'next_chapter_id' => $chapters1['good_end']->id
            ]);

            // Branche neutre
            Choice::create([
                'chapter_id' => $chapters1['cafe']->id,
                'text' => 'Essayer d\'approfondir la conversation',
                'next_chapter_id' => $chapters1['discussion']->id
            ]);
            Choice::create([
                'chapter_id' => $chapters1['cafe']->id,
                'text' => 'Continuer la conversation légère',
                'next_chapter_id' => $chapters1['smalltalk']->id
            ]);

            Choice::create([
                'chapter_id' => $chapters1['smalltalk']->id,
                'text' => 'Accepter que ça reste amical',
                'next_chapter_id' => $chapters1['friend_end']->id
            ]);
            Choice::create([
                'chapter_id' => $chapters1['smalltalk']->id,
                'text' => 'Regarder discrètement ton téléphone',
                'next_chapter_id' => $chapters1['phone']->id
            ]);

            // Branche négative
            Choice::create([
                'chapter_id' => $chapters1['phone']->id,
                'text' => 'Ranger ton téléphone et t\'excuser',
                'next_chapter_id' => $chapters1['smalltalk']->id
            ]);
            Choice::create([
                'chapter_id' => $chapters1['phone']->id,
                'text' => 'Continuer à regarder ton téléphone',
                'next_chapter_id' => $chapters1['bad_end']->id
            ]);

            Choice::create([
                'chapter_id' => $chapters1['ex']->id,
                'text' => 'Changer rapidement de sujet',
                'next_chapter_id' => $chapters1['smalltalk']->id
            ]);
            Choice::create([
                'chapter_id' => $chapters1['ex']->id,
                'text' => 'Continuer à parler de ton ex',
                'next_chapter_id' => $chapters1['bad_end']->id
            ]);

            Log::info('StorySeeder completed successfully');
        } catch (\Exception $e) {
            Log::error('Error in StorySeeder: ' . $e->getMessage());
            throw $e;
        }
    }
}
