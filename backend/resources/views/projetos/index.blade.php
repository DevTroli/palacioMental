<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl sm:text-3xl font-serif text-palacio-roxo tracking-wide">
                Projetos
            </h1>
            @auth
                <a href="{{ route('projetos.create') }}" class="btn-primary !text-sm">
                    + Novo Projeto
                </a>
            @endauth
        </div>

        @if($projetos->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projetos as $projeto)
                    <a href="{{ route('projetos.show', $projeto) }}" class="card group flex flex-col">
                        <div class="h-2 rounded-t-xl {{ $projeto->categoria ? 'bg-palacio-verde' : 'bg-palacio-roxo/30' }}"></div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-serif text-lg text-palacio-roxo group-hover:text-palacio-verde transition-colors line-clamp-2">
                                {{ $projeto->titulo }}
                            </h3>
                            <p class="mt-2 text-sm text-palacio-escuro/60 line-clamp-3 flex-1">
                                {{ Str::limit($projeto->descricao, 120) }}
                            </p>
                            @if($projeto->tags->count())
                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    @foreach($projeto->tags->take(3) as $tag)
                                        <span class="chip text-[10px] !px-2 !py-0.5">{{ $tag->nome }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <div class="flex items-center justify-between mt-4 pt-3 border-t border-palacio-bege/60">
                                <div class="flex items-center space-x-2">
                                    @if($projeto->user->avatar_url)
                                        <img src="{{ $projeto->user->avatar_url }}" alt="{{ $projeto->user->name }}" class="w-6 h-6 rounded-full object-cover">
                                    @else
                                        <div class="w-6 h-6 rounded-full bg-palacio-verde/10 flex items-center justify-center text-palacio-verde text-[10px] font-serif font-bold">
                                            {{ strtoupper($projeto->user->name[0]) }}
                                        </div>
                                    @endif
                                    <span class="text-xs text-palacio-escuro/60">{{ '@' . $projeto->user->username }}</span>
                                </div>
                                @if($projeto->categoria)
                                    <span class="text-[10px] bg-palacio-verde/10 text-palacio-verde px-2 py-0.5 rounded-full font-medium">
                                        {{ $projeto->categoria->nome }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $projetos->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <div class="text-6xl mb-4 opacity-30">&#x1F3DB;</div>
                <h2 class="font-serif text-xl text-palacio-roxo/60">Nenhum projeto encontrado</h2>
            </div>
        @endif
    </div>
</x-app-layout>
