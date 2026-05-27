<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Projeto;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        $query = Projeto::publico()
            ->with('user', 'categoria', 'tags', 'curtidas');

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', fn ($q) => $q->where('tags.id', $request->tag));
        }

        if ($request->filled('busca')) {
            $query->where('titulo', 'like', '%' . $request->busca . '%');
        }

        $projetos = $query->latest()->paginate(12);
        $categorias = Categoria::orderBy('nome')->get();

        return view('feed.index', compact('projetos', 'categorias'));
    }
}
