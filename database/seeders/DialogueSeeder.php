<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Word;
use App\Models\GrammarTemplate;
use Illuminate\Database\Seeder;

class DialogueSeeder extends Seeder
{
    /**
     * Seed a modest, curated Hylics-style vocabulary and templates.
     */
    public function run(): void
    {
        // 1. Curated Vocabulary Categories and Words
        $lexicon = [
            'creature' => [
                'name' => 'Creatures & Entities',
                'description' => 'Organic and clay beings inhabiting the world',
                'words' => [
                    ['text' => 'bicuspid', 'weight' => 60],
                    ['text' => 'clay monk', 'weight' => 50],
                    ['text' => 'larva', 'weight' => 40],
                    ['text' => 'sculptor', 'weight' => 40],
                    ['text' => 'horned visage', 'weight' => 15],
                ],
            ],
            'adj' => [
                'name' => 'Descriptive Adjectives',
                'description' => 'Sensory, physical, and surreal descriptors',
                'words' => [
                    ['text' => 'waxen', 'weight' => 60],
                    ['text' => 'fibrous', 'weight' => 60],
                    ['text' => 'brittle', 'weight' => 50],
                    ['text' => 'porcelain', 'weight' => 40],
                    ['text' => 'lunar', 'weight' => 30],
                    ['text' => 'curdled', 'weight' => 20],
                    ['text' => 'forbidden', 'weight' => 10],
                ],
            ],
            'noun' => [
                'name' => 'Substances & Relics',
                'description' => 'Geologic, organic, and archaic materials',
                'words' => [
                    ['text' => 'loam', 'weight' => 60],
                    ['text' => 'marrow', 'weight' => 50],
                    ['text' => 'visage', 'weight' => 50],
                    ['text' => 'chitin', 'weight' => 40],
                    ['text' => 'basalt', 'weight' => 40],
                    ['text' => 'foam', 'weight' => 30],
                    ['text' => 'god-flesh', 'weight' => 5], // Ultra rare
                ],
            ],
            'liquid' => [
                'name' => 'Liquids & Draughts',
                'description' => 'Fluids that can be poured, sipped, or decanted',
                'words' => [
                    ['text' => 'tea', 'weight' => 70],
                    ['text' => 'marrow juice', 'weight' => 40],
                    ['text' => 'froth', 'weight' => 30],
                    ['text' => 'black bile', 'weight' => 15],
                ],
            ],
            'place' => [
                'name' => 'Locations & Vessels',
                'description' => 'Surreal geography and monuments',
                'words' => [
                    ['text' => 'the basalt well', 'weight' => 50],
                    ['text' => 'the dunes of dust', 'weight' => 50],
                    ['text' => 'the clay cavern', 'weight' => 40],
                    ['text' => 'the ceiling of flesh', 'weight' => 20],
                ],
            ],
            'trans_verb' => [
                'name' => 'Transitive Verbs (Singular)',
                'description' => 'Actions performed by singular subjects',
                'words' => [
                    ['text' => 'dissolves', 'weight' => 60],
                    ['text' => 'churns', 'weight' => 50],
                    ['text' => 'decants', 'weight' => 40],
                    ['text' => 'anoints', 'weight' => 30],
                    ['text' => 'swallows', 'weight' => 30],
                ],
            ],
            'imp_verb' => [
                'name' => 'Imperative Command Verbs',
                'description' => 'Commands spoken to the player',
                'words' => [
                    ['text' => 'Decant', 'weight' => 50],
                    ['text' => 'Sever', 'weight' => 40],
                    ['text' => 'Pucker', 'weight' => 30],
                    ['text' => 'Knead', 'weight' => 30],
                    ['text' => 'Anoint', 'weight' => 20],
                ],
            ],
        ];

        // Seed categories and words
        foreach ($lexicon as $tag => $data) {
            $category = Category::firstOrCreate(
                ['tag' => $tag],
                ['name' => $data['name'], 'description' => $data['description']]
            );

            foreach ($data['words'] as $w) {
                Word::firstOrCreate(
                    ['category_id' => $category->id, 'text' => $w['text']],
                    ['weight' => $w['weight']]
                );
            }
        }

        // 2. Curated Grammar Templates (Organized by Archetype Groups)
        $templates = [
            // Group: Ominous (World observations)
            [
                'pattern' => 'The {adj} {creature} {trans_verb} within {place}.',
                'group' => 'ominous',
                'weight' => 50,
            ],
            [
                'pattern' => 'A {adj} {noun} slumbers beneath {place}.',
                'group' => 'ominous',
                'weight' => 40,
            ],
            [
                'pattern' => 'The {creature} drinks the {liquid} before sunrise.',
                'group' => 'ominous',
                'weight' => 40,
            ],

            // Group: Cryptic (NPC advice / instructions)
            [
                'pattern' => '{imp_verb} the {noun} before your visage turns to {adj} {noun}.',
                'group' => 'cryptic',
                'weight' => 50,
            ],
            [
                'pattern' => 'Never pour {liquid} across {place}.',
                'group' => 'cryptic',
                'weight' => 40,
            ],
            [
                'pattern' => '{imp_verb} the {adj} {creature} with {liquid}.',
                'group' => 'cryptic',
                'weight' => 30,
            ],

            // Group: Prophecy (Portents and doom)
            [
                'pattern' => 'When the {adj} moon aligns, all {noun} will dissolve into {liquid}.',
                'group' => 'prophecy',
                'weight' => 50,
            ],
            [
                'pattern' => 'The {creature} shall swallow the {noun} of {place}.',
                'group' => 'prophecy',
                'weight' => 40,
            ],
        ];

        foreach ($templates as $t) {
            GrammarTemplate::firstOrCreate(
                ['pattern' => $t['pattern']],
                ['group' => $t['group'], 'weight' => $t['weight'], 'is_active' => true]
            );
        }
    }
}

