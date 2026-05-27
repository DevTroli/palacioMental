<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            // Linguagens & Frameworks
            'php', 'laravel', 'python', 'javascript', 'react', 'java', 'csharp', 'flutter', 'nodejs', 'django',
            // Banco de dados
            'mysql', 'oracle', 'postgresql', 'mongodb', 'banco-de-dados',
            // DevOps & Infra
            'docker', 'aws', 'git', 'ci-cd', 'linux',
            // IA & Dados
            'tensorflow', 'machine-learning', 'data-science', 'nlp', 'visao-computacional',
            // Design & Frontend
            'figma', 'css', 'tailwind', 'ux-design', 'acessibilidade',
            // Hardware & IoT
            'arduino', 'raspberry-pi', 'sensores', 'embarcados',
            // Games
            'unity', 'godot', 'game-design', '3d',
            // Mobile
            'android', 'ios', 'kotlin', 'swift',
            // Metodologias
            'api', 'mvc', 'rest', 'agile', 'scrum', 'testes',
            // Acadêmico
            'tcc', 'pesquisa', 'artigo-cientifico', 'revisao-sistemática',
        ];

        foreach ($tags as $nome) {
            Tag::create(['nome' => $nome]);
        }
    }
}
