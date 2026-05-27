<?php

namespace Database\Seeders;

use App\Models\Midia;
use App\Models\Projeto;
use Illuminate\Database\Seeder;

class MidiaSeeder extends Seeder
{
    public function run(): void
    {
        $projetosPublicos = Projeto::where('status', 'publico')->get();

        $midiasData = [
            // Projeto 1 — Palácio Mental
            [
                'projeto_id' => 1,
                'midias' => [
                    ['tipo' => 'imagem', 'url' => 'https://images.unsplash.com/photo-1461749280684-dccba690e2f6?w=800'],
                    ['tipo' => 'link', 'url' => 'https://github.com/DevTroli/palacioMental'],
                ],
            ],
            // Projeto 2 — Estufa Arduino
            [
                'projeto_id' => 2,
                'midias' => [
                    ['tipo' => 'imagem', 'url' => 'https://images.unsplash.com/photo-1574182245530-967d9b3831af?w=800'],
                    ['tipo' => 'link', 'url' => 'https://www.arduino.cc/en/Tutorial/HomePage'],
                ],
            ],
            // Projeto 3 — API Tarefas
            [
                'projeto_id' => 3,
                'midias' => [
                    ['tipo' => 'imagem', 'url' => 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=800'],
                ],
            ],
            // Projeto 6 — E-Commerce Livros
            [
                'projeto_id' => 6,
                'midias' => [
                    ['tipo' => 'imagem', 'url' => 'https://images.unsplash.com/photo-1495444093238-a9f1fca2c7b1?w=800'],
                    ['tipo' => 'link', 'url' => 'https://stripe.com/docs/api'],
                ],
            ],
            // Projeto 7 — App Financeiro
            [
                'projeto_id' => 7,
                'midias' => [
                    ['tipo' => 'imagem', 'url' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=800'],
                ],
            ],
            // Projeto 9 — Doenças Plantas
            [
                'projeto_id' => 9,
                'midias' => [
                    ['tipo' => 'imagem', 'url' => 'https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?w=800'],
                    ['tipo' => 'link', 'url' => 'https://www.tensorflow.org/tutorials/images/classification'],
                ],
            ],
            // Projeto 10 — Microserviços Docker
            [
                'projeto_id' => 10,
                'midias' => [
                    ['tipo' => 'imagem', 'url' => 'https://images.unsplash.com/photo-1605745341112-85968b19335b?w=800'],
                ],
            ],
            // Projeto 11 — Automação ESP32
            [
                'projeto_id' => 11,
                'midias' => [
                    ['tipo' => 'imagem', 'url' => 'https://images.unsplash.com/photo-1558002038-1055907df827?w=800'],
                    ['tipo' => 'link', 'url' => 'https://mqtt.org/'],
                ],
            ],
            // Projeto 12 — Jogo Unity
            [
                'projeto_id' => 12,
                'midias' => [
                    ['tipo' => 'imagem', 'url' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=800'],
                ],
            ],
            // Projeto 13 — Dashboard COVID
            [
                'projeto_id' => 13,
                'midias' => [
                    ['tipo' => 'imagem', 'url' => 'https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?w=800'],
                ],
            ],
            // Projeto 14 — App Saúde Mental
            [
                'projeto_id' => 14,
                'midias' => [
                    ['tipo' => 'imagem', 'url' => 'https://images.unsplash.com/photo-1493837448041-5e4e7652e7c4?w=800'],
                    ['tipo' => 'link', 'url' => 'https://www.figma.com/community'],
                ],
            ],
            // Projeto 15 — Pipeline CI/CD
            [
                'projeto_id' => 15,
                'midias' => [
                    ['tipo' => 'imagem', 'url' => 'https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?w=800'],
                ],
            ],
        ];

        foreach ($midiasData as $data) {
            foreach ($data['midias'] as $midia) {
                Midia::create([
                    'projeto_id' => $data['projeto_id'],
                    'tipo' => $midia['tipo'],
                    'url' => $midia['url'],
                ]);
            }
        }
    }
}
