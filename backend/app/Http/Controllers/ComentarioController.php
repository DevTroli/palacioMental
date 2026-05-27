<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Projeto;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Projeto $projeto)
    {
        $request->validate([
            'conteudo' => ['required', 'string', 'max:2000'],
        ]);

        $projeto->comentarios()->create([
            'user_id'   => auth()->id(),
            'conteudo'  => $request->conteudo,
        ]);

        return back()->with('success', 'Comentário adicionado!');
    }
}
