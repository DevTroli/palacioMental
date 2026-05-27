<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjetoRequest;
use App\Http\Requests\UpdateProjetoRequest;
use App\Models\Categoria;
use App\Models\Midia;
use App\Models\Projeto;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Projeto::publico()->with('user', 'categoria', 'tags');

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        $projetos = $query->latest()->paginate(12);

        return view('projetos.index', compact('projetos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nome')->get();
        $tags = Tag::orderBy('nome')->get();

        return view('projetos.create', compact('categorias', 'tags'));
    }

    public function store(StoreProjetoRequest $request)
    {
        $data = $request->validated();

        // Botão "Publicar" ou "Salvar Rascunho" define o status
        if ($request->has('status') && in_array($request->status, ['rascunho', 'publico', 'privado'])) {
            $data['status'] = $request->status;
        }

        $projeto = auth()->user()->projetos()->create($data);

        $projeto->tags()->sync($request->input('tags', []));

        $this->syncMidias($projeto, $request);

        return redirect()->route('projetos.show', $projeto)
            ->with('success', 'Projeto criado com sucesso!');
    }

    public function show(Projeto $projeto)
    {
        $projeto->load('user', 'categoria', 'tags', 'midias', 'comentarios.user', 'curtidas', 'salvos');

        return view('projetos.show', compact('projeto'));
    }

    public function edit(Projeto $projeto)
    {
        $this->authorizeOwner($projeto);

        $categorias = Categoria::orderBy('nome')->get();
        $tags = Tag::orderBy('nome')->get();
        $projeto->load('tags', 'midias');

        return view('projetos.edit', compact('projeto', 'categorias', 'tags'));
    }

    public function update(UpdateProjetoRequest $request, Projeto $projeto)
    {
        $this->authorizeOwner($projeto);

        $data = $request->validated();

        if ($request->has('status') && in_array($request->status, ['rascunho', 'publico', 'privado'])) {
            $data['status'] = $request->status;
        }

        $projeto->update($data);

        $projeto->tags()->sync($request->input('tags', []));

        $this->syncMidias($projeto, $request);

        return redirect()->route('projetos.show', $projeto)
            ->with('success', 'Projeto atualizado com sucesso!');
    }

    public function destroy(Projeto $projeto)
    {
        $this->authorizeOwner($projeto);

        $projeto->delete();

        return redirect()->route('feed')
            ->with('success', 'Projeto excluído com sucesso!');
    }

    private function authorizeOwner(Projeto $projeto): void
    {
        if ($projeto->user_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para esta ação.');
        }
    }

    private function syncMidias(Projeto $projeto, Request $request): void
    {
        // Remover mídias marcadas para exclusão (edit form)
        if ($request->has('remover_midias')) {
            Midia::whereIn('id', $request->remover_midias)
                ->where('projeto_id', $projeto->id)
                ->delete();
        }

        // Mídias do create (midias[] + midia_tipos[])
        if ($request->has('midias') && $request->has('midia_tipos')) {
            foreach ($request->midias as $i => $url) {
                if (!empty($url)) {
                    $projeto->midias()->create([
                        'tipo' => $request->midia_tipos[$i] ?? 'link',
                        'url'  => $url,
                    ]);
                }
            }
        }

        // Novas mídias do edit (novas_midias[] + novas_midia_tipos[])
        if ($request->has('novas_midias') && $request->has('novas_midia_tipos')) {
            foreach ($request->novas_midias as $i => $url) {
                if (!empty($url)) {
                    $projeto->midias()->create([
                        'tipo' => $request->novas_midia_tipos[$i] ?? 'link',
                        'url'  => $url,
                    ]);
                }
            }
        }
    }
}
