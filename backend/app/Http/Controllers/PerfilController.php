<?php

namespace App\Http\Controllers;

use App\Models\User;

class PerfilController extends Controller
{
    public function show(string $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $isOwner = auth()->check() && auth()->id() === $user->id;

        $projetos = $isOwner
            ? $user->projetos()->with('categoria', 'tags')->latest()->get()
            : $user->projetos()->publico()->with('categoria', 'tags')->latest()->get();

        return view('perfil.show', compact('user', 'projetos', 'isOwner'));
    }
}
