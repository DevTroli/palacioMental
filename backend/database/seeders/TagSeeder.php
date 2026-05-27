<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'php',
            'laravel',
            'oracle',
            'mysql',
            'docker',
            'python',
            'javascript',
            'react',
            'figma',
            'arduino',
            'unity',
            'tensorflow',
            'api',
            'mvc',
            'banco-de-dados',
        ];

        foreach ($tags as $nome) {
            Tag::create(['nome' => $nome]);
        }
    }
}
