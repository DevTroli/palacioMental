<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Pablo Troli',
                'username' => 'troli',
                'email' => 'troli@palaciomental.com',
                'password' => Hash::make('password'),
                'bio' => 'Tech Lead & DB Lead do Palácio Mental. Apaixonado por bancos de dados e arquitetura de software.',
            ],
            [
                'name' => 'Felipe Santos',
                'username' => 'felipe',
                'email' => 'felipe@palaciomental.com',
                'password' => Hash::make('password'),
                'bio' => 'Desenvolvedor backend focado em PHP e Laravel.',
            ],
            [
                'name' => 'Eduardo Silva',
                'username' => 'eduardo',
                'email' => 'eduardo@palaciomental.com',
                'password' => Hash::make('password'),
                'bio' => 'Desenvolvedor backend com interesse em APIs REST e integração de sistemas.',
            ],
            [
                'name' => 'Iago Oliveira',
                'username' => 'iago',
                'email' => 'iago@palaciomental.com',
                'password' => Hash::make('password'),
                'bio' => 'Desenvolvedor frontend entusiasta de React e interfaces acessíveis.',
            ],
            [
                'name' => 'Yohan Costa',
                'username' => 'yohan',
                'email' => 'yohan@palaciomental.com',
                'password' => Hash::make('password'),
                'bio' => 'Designer UX/UI — transforma ideias em experiências memoráveis.',
            ],
            [
                'name' => 'Matheus Lima',
                'username' => 'matheus',
                'email' => 'matheus@palaciomental.com',
                'password' => Hash::make('password'),
                'bio' => 'DevOps e documentação — garante que tudo rode e esteja registrado.',
            ],
        ];

        foreach ($users as $userData) {
            User::create(array_merge($userData, [
                'email_verified_at' => now(),
            ]));
        }
    }
}
