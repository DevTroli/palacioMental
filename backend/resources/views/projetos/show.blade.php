<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            {{-- Badge de status --}}
            <div class="mb-3">
                @php
                    $statusColors = [
                        'rascunho' => 'bg-gray-200 text-gray-700',
                        'publico'  => 'bg-palacio-verde/10 text-palacio-verde',
                        'privado'  => 'bg-palacio-roxo/10 text-palacio-roxo',
                    ];
                @endphp
                <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $statusColors[$projeto->status] ?? '' }}">
                    {{ ucfirst($projeto->status) }}
                </span>
            </div>

            <h1 class="font-serif text-3xl text-palacio-roxo mb-4">{{ $projeto->titulo }}</h1>

            {{-- Autor + data --}}
            <div class="flex items-center space-x-3 mb-4">
                <a href="{{ url('/u/' . $projeto->user->username) }}" class="flex items-center space-x-2 hover:opacity-80 transition-opacity">
                    @if($projeto->user->avatar_url)
                        <img src="{{ $projeto->user->avatar_url }}" class="w-10 h-10 rounded-full object-cover border-2 border-palacio-bege">
                    @else
                        <div class="w-10 h-10 rounded-full bg-palacio-roxo flex items-center justify-center text-palacio-bege text-sm font-serif">
                            {{ strtoupper($projeto->user->name[0]) }}
                        </div>
                    @endif
                    <span class="text-sm font-medium text-palacio-escuro/80">{{ $projeto->user->name }}</span>
                    <span class="text-xs text-palacio-escuro/50">@{{ $projeto->user->username }}</span>
                </a>
                <span class="text-palacio-escuro/30">&middot;</span>
                <span class="text-xs text-palacio-escuro/50">{{ $projeto->created_at->format('d M Y') }}</span>

                @if($projeto->categoria)
                    <span class="text-palacio-escuro/30">&middot;</span>
                    <span class="chip">{{ $projeto->categoria->nome }}</span>
                @endif
            </div>

            {{-- Ações: curtir + salvar + editar se dono --}}
            <div class="flex items-center space-x-3">
                <x-curtida-toggle :projeto="$projeto" />
                <x-salvo-toggle :projeto="$projeto" />

                @auth
                    @if($projeto->user_id === auth()->id())
                        <a href="{{ route('projetos.edit', $projeto) }}" class="btn-outline text-xs py-1.5 px-3 ml-auto">
                            Editar
                        </a>
                        <form action="{{ route('projetos.destroy', $projeto) }}" method="POST"
                              onsubmit="return confirm('Tem certeza que deseja excluir este projeto?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-500 hover:text-red-700 transition-colors">Excluir</button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>

        {{-- Descrição --}}
        <div class="prose max-w-none bg-white rounded-xl p-6 border border-palacio-bege/60 mb-8">
            {{ $projeto->descricao }}
        </div>

        {{-- Galeria de mídias --}}
        @if($projeto->midias->count())
            <div class="mb-8">
                <h2 class="font-serif text-xl text-palacio-roxo mb-4">Mídias</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($projeto->midias as $midia)
                        @if($midia->tipo === 'imagem')
                            <div class="rounded-lg overflow-hidden border border-palacio-bege/60">
                                <img src="{{ $midia->url }}" alt="Mídia do projeto" class="w-full h-48 object-cover">
                            </div>
                        @elseif($midia->tipo === 'video')
                            @php
                                $isYoutube = preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $midia->url, $matches);
                            @endphp
                            @if($isYoutube)
                                <div class="rounded-lg overflow-hidden border border-palacio-bege/60 aspect-video">
                                    <iframe src="https://www.youtube.com/embed/{{ $matches[1] }}"
                                            class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                                </div>
                            @else
                                <a href="{{ $midia->url }}" target="_blank" rel="noopener"
                                   class="flex items-center space-x-3 p-4 rounded-lg border border-palacio-bege/60 bg-white hover:bg-palacio-bege/50 transition-colors">
                                    <svg class="w-8 h-8 text-palacio-roxo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm text-palacio-roxo truncate">{{ $midia->url }}</span>
                                </a>
                            @endif
                        @elseif($midia->tipo === 'link')
                            <a href="{{ $midia->url }}" target="_blank" rel="noopener"
                               class="flex items-center space-x-3 p-4 rounded-lg border border-palacio-bege/60 bg-white hover:bg-palacio-bege/50 transition-colors">
                                <svg class="w-8 h-8 text-palacio-verde" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                <span class="text-sm text-palacio-verde truncate">{{ $midia->url }}</span>
                            </a>
                        @elseif($midia->tipo === 'audio')
                            <div class="p-4 rounded-lg border border-palacio-bege/60 bg-white">
                                <div class="flex items-center space-x-3 mb-2">
                                    <svg class="w-6 h-6 text-palacio-laranja" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                    </svg>
                                    <span class="text-sm text-palacio-escuro/60">Áudio</span>
                                </div>
                                <audio controls class="w-full">
                                    <source src="{{ $midia->url }}">
                                </audio>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Tags --}}
        @if($projeto->tags->count())
            <div class="mb-8">
                <div class="flex flex-wrap gap-2">
                    @foreach($projeto->tags as $tag)
                        <a href="{{ route('feed', ['tag' => $tag->id]) }}" class="chip hover:opacity-80 transition-opacity no-underline">
                            {{ $tag->nome }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Separador --}}
        <hr class="border-palacio-bege my-8">

        {{-- Comentários --}}
        <div>
            <h2 class="font-serif text-xl text-palacio-roxo mb-6">
                Comentários ({{ $projeto->comentarios->count() }})
            </h2>

            @if($projeto->comentarios->count())
                <div class="space-y-4 mb-8">
                    @foreach($projeto->comentarios as $comentario)
                        <div class="bg-white rounded-lg p-4 border border-palacio-bege/60">
                            <div class="flex items-center space-x-2 mb-2">
                                @if($comentario->user->avatar_url)
                                    <img src="{{ $comentario->user->avatar_url }}" class="w-7 h-7 rounded-full object-cover">
                                @else
                                    <div class="w-7 h-7 rounded-full bg-palacio-roxo flex items-center justify-center text-palacio-bege text-[10px] font-serif">
                                        {{ strtoupper($comentario->user->name[0]) }}
                                    </div>
                                @endif
                                <span class="text-sm font-medium text-palacio-escuro/80">{{ $comentario->user->name }}</span>
                                <span class="text-xs text-palacio-escuro/40">{{ $comentario->created_at->format('d M Y · H:i') }}</span>
                            </div>
                            <p class="text-sm text-palacio-escuro/70 pl-9">{{ $comentario->conteudo }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-palacio-escuro/50 mb-6">Nenhum comentário ainda. Seja o primeiro!</p>
            @endif

            @auth
                <form action="{{ route('comentarios.store', $projeto) }}" method="POST">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-palacio-escuro/70 mb-1">
                            Adicionar comentário
                        </label>
                        <textarea name="conteudo" rows="3"
                                  class="w-full rounded-lg border border-palacio-bege bg-white p-3 text-sm focus:border-palacio-verde focus:ring-palacio-verde"
                                  placeholder="Escreva seu comentário...">{{ old('conteudo') }}</textarea>
                        @error('conteudo')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mt-3 text-right">
                        <button type="submit" class="btn-primary text-xs py-2 px-4">Comentar</button>
                    </div>
                </form>
            @else
                <div class="bg-palacio-bege/50 rounded-lg p-4 text-center">
                    <p class="text-sm text-palacio-escuro/60">
                        <a href="{{ route('login') }}" class="text-palacio-verde hover:underline">Faça login</a> para comentar.
                    </p>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout>
