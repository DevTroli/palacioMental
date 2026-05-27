<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header do perfil --}}
        <div class="bg-white rounded-xl border border-palacio-bege/60 p-6 mb-8">
            <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6">
                {{-- Avatar --}}
                @if($user->avatar_url)
                    <img src="{{ $user->avatar_url }}" class="w-24 h-24 rounded-full object-cover border-4 border-palacio-bege">
                @else
                    <div class="w-24 h-24 rounded-full bg-palacio-roxo flex items-center justify-center text-palacio-bege text-3xl font-serif">
                        {{ strtoupper($user->name[0]) }}
                    </div>
                @endif

                <div class="flex-1 text-center sm:text-left">
                    <h1 class="font-serif text-2xl text-palacio-roxo">{{ $user->name }}</h1>
                    @if($user->username)
                        <p class="text-sm text-palacio-escuro/50">@{{ $user->username }}</p>
                    @endif
                    @if($user->bio)
                        <p class="text-sm text-palacio-escuro/70 mt-2">{{ $user->bio }}</p>
                    @endif

                    <div class="mt-3 flex items-center justify-center sm:justify-start space-x-4 text-sm text-palacio-escuro/60">
                        <span class="font-serif font-medium text-palacio-verde">{{ $user->projetos()->count() }}</span>
                        <span>projetos publicados</span>
                    </div>
                </div>

                @if($isOwner)
                    <a href="{{ route('projetos.create') }}" class="btn-primary whitespace-nowrap">
                        + Novo Projeto
                    </a>
                @endif
            </div>
        </div>

        {{-- Tabs: Projetos e Salvos --}}
        <div x-data="{ tab: 'projetos' }">
            <div class="flex border-b border-palacio-bege/60 mb-6">
                <button @click="tab = 'projetos'"
                        :class="tab === 'projetos' ? 'border-palacio-verde text-palacio-verde' : 'border-transparent text-palacio-escuro/50 hover:text-palacio-escuro/70'"
                        class="px-4 py-2 text-sm font-serif border-b-2 transition-colors">
                    Projetos
                </button>

                @if($isOwner)
                    <button @click="tab = 'salvos'"
                            :class="tab === 'salvos' ? 'border-palacio-verde text-palacio-verde' : 'border-transparent text-palacio-escuro/50 hover:text-palacio-escuro/70'"
                            class="px-4 py-2 text-sm font-serif border-b-2 transition-colors">
                        Salvos
                    </button>
                @endif
            </div>

            {{-- Tab Projetos --}}
            <div x-show="tab === 'projetos'">
                @if($projetos->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($projetos as $projeto)
                            <div class="card overflow-hidden group">
                                <div class="h-2 {{ $projeto->categoria ? 'bg-palacio-verde' : 'bg-palacio-roxo/30' }}"></div>
                                <div class="p-5">
                                    <a href="{{ route('projetos.show', $projeto) }}" class="no-underline">
                                        <h3 class="font-serif text-lg text-palacio-roxo group-hover:text-palacio-verde transition-colors line-clamp-2 mb-2">
                                            {{ $projeto->titulo }}
                                        </h3>
                                    </a>
                                    <p class="text-sm text-palacio-escuro/70 line-clamp-2 mb-4">
                                        {{ Str::limit($projeto->descricao, 100) }}
                                    </p>

                                    @if($projeto->tags->count())
                                        <div class="flex flex-wrap gap-1.5 mb-3">
                                            @foreach($projeto->tags as $tag)
                                                <span class="chip text-[10px] px-2 py-0.5">{{ $tag->nome }}</span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between pt-3 border-t border-palacio-bege/60">
                                        <span class="text-xs font-medium px-2 py-0.5 rounded {{ $projeto->status === 'publico' ? 'bg-palacio-verde/10 text-palacio-verde' : ($projeto->status === 'rascunho' ? 'bg-gray-200 text-gray-700' : 'bg-palacio-roxo/10 text-palacio-roxo') }}">
                                            {{ ucfirst($projeto->status) }}
                                        </span>

                                        @if($isOwner)
                                            <div class="flex space-x-2">
                                                <a href="{{ route('projetos.edit', $projeto) }}" class="text-xs text-palacio-verde hover:underline">Editar</a>
                                                <form action="{{ route('projetos.destroy', $projeto) }}" method="POST"
                                                      onsubmit="return confirm('Excluir este projeto?')">
                                                    @csrf @method('DELETE')
                                                    <button class="text-xs text-red-500 hover:underline">Excluir</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <p class="text-sm text-palacio-escuro/50 mb-4">
                            @if($isOwner)
                                Você ainda não criou nenhum projeto.
                            @else
                                Nenhum projeto público encontrado.
                            @endif
                        </p>
                        @if($isOwner)
                            <a href="{{ route('projetos.create') }}" class="btn-primary">Criar Projeto</a>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Tab Salvos --}}
            @if($isOwner)
                <div x-show="tab === 'salvos'" x-cloak>
                    @php
                        $salvos = $user->salvos()->with('categoria', 'tags', 'user', 'curtidas')->latest()->get();
                    @endphp

                    @if($salvos->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($salvos as $projeto)
                                <a href="{{ route('projetos.show', $projeto) }}" class="card overflow-hidden group no-underline">
                                    <div class="h-2 bg-palacio-laranja"></div>
                                    <div class="p-5">
                                        <h3 class="font-serif text-lg text-palacio-roxo group-hover:text-palacio-verde transition-colors line-clamp-2 mb-2">
                                            {{ $projeto->titulo }}
                                        </h3>
                                        <p class="text-sm text-palacio-escuro/70 line-clamp-2 mb-3">
                                            {{ Str::limit($projeto->descricao, 100) }}
                                        </p>
                                        <div class="flex items-center space-x-2 text-xs text-palacio-escuro/50">
                                            <span>{{ $projeto->user->name }}</span>
                                            <span>&middot;</span>
                                            <span class="flex items-center space-x-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                                {{ $projeto->curtidas->count() }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <p class="text-sm text-palacio-escuro/50">Nenhum projeto salvo ainda.</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
