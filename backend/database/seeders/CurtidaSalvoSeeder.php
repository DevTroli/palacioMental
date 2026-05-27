<?php

namespace Database\Seeders;

use App\Models\Projeto;
use App\Models\User;
use Illuminate\Database\Seeder;

class CurtidaSalvoSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $projetosPublicos = Projeto::where('status', 'publico')->get();

        // Curtidas: cada usuário curte de 2 a 5 projetos aleatórios
        foreach ($users as $user) {
            $projetosParaCurtir = $projetosPublicos->random(min(rand(2, 5), $projetosPublicos->count()));
            foreach ($projetosParaCurtir as $projeto) {
                $projeto->curtidas()->syncWithoutDetaching([$user->id]);
            }
        }

        // Salvos: cada usuário salva de 1 a 3 projetos aleatórios
        foreach ($users as $user) {
            $projetosParaSalvar = $projetosPublicos->random(min(rand(1, 3), $projetosPublicos->count()));
            foreach ($projetosParaSalvar as $projeto) {
                $projeto->salvos()->syncWithoutDetaching([$user->id]);
            }
        }
    }
}
