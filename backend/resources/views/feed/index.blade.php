<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-serif text-palacio-roxo tracking-wide">
                Explore o Palácio
            </h1>
            <p class="mt-2 text-palacio-verde/70 font-serif text-sm tracking-wider">
                Descubra projetos acadêmicos incríveis
            </p>
        </div>

        {{-- Filtros --}}
        <div class="bg-white rounded-xl shadow-sm border border-palacio-bege/60 p-5 mb-8">
            <form method="GET" action="{{ route('feed') }}" class="space-y-4">
                <div class="flex flex-col sm:flex-row gap-4">
                    {{-- Busca por título --}}
                    <div class="flex-1">
                        <input type="text" name="busca" value="{{ request('busca') }}"
                            placeholder="Buscar projetos por título..."
                            class="w-full rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30">
                    </div>

                    {{-- Dropdown categorias --}}
                    <div class="sm:w-56">
                        <select name="categoria_id"
                            class="w-full rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30">
                            <option value="">Todas as categorias</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Botão filtrar --}}
                    <button type="submit" class="btn-primary !text-sm whitespace-nowrap">
                        Filtrar
                    </button>
                </div>

                {{-- Tags — collapsible com busca --}}
                @php
                    $allTags = $tags ?? \App\Models\Tag::orderBy('nome')->get();
                    $activeTagId = request('tag');
                    $initialLimit = 10;
                @endphp

                @if($allTags->count())
                <div x-data="{
                    search: '',
                    expanded: false,
                    initialLimit: {{ $initialLimit }},
                    allTags: {{ $allTags->map(fn($t) => ['id' => $t->id, 'nome' => $t->nome])->values()->toJson() }},
                    activeTag: {{ $activeTagId ? $activeTagId : 'null' }},
                    get filtered() {
                        return this.allTags.filter(t =>
                            t.nome.toLowerCase().includes(this.search.toLowerCase())
                        );
                    },
                    get visible() {
                        return this.expanded ? this.filtered : this.filtered.slice(0, this.initialLimit);
                    },
                    get hasMore() {
                        return this.filtered.length > this.initialLimit;
                    },
                    tagUrl(id) {
                        const params = new URLSearchParams(window.location.search);
                        if (this.activeTag == id) { params.delete('tag'); }
                        else { params.set('tag', id); }
                        params.delete('page');
                        return '{{ route('feed') }}?' + params.toString();
                    },
                    isActive(id) {
                        return this.activeTag == id;
                    }
                }">
                    {{-- Tag ativa como badge removível --}}
                    @if($activeTagId)
                        @php $activeTag = $allTags->firstWhere('id', $activeTagId); @endphp
                        @if($activeTag)
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs text-palacio-escuro/50">Filtrando por:</span>
                                <a href="{{ route('feed', array_merge(request()->except(['tag', 'page']))) }}"
                                   class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-palacio-verde/10 text-palacio-verde border border-palacio-verde/20 hover:bg-palacio-verde/20 transition-colors">
                                    {{ $activeTag->nome }}
                                    <span>&times;</span>
                                </a>
                            </div>
                        @endif
                    @endif

                    {{-- Busca de tags (só aparece se tiver muitas) --}}
                    @if($allTags->count() > $initialLimit)
                    <input type="text" x-model="search"
                        class="w-full rounded-lg border border-palacio-bege bg-palacio-claro text-xs px-3 py-1.5 mb-2 focus:border-palacio-verde focus:ring-palacio-verde/30 placeholder:text-palacio-escuro/30"
                        placeholder="Buscar tags..." />
                    @endif

                    {{-- Chips de tags --}}
                    <div class="flex flex-wrap gap-1.5">
                        <template x-for="tag in visible" :key="tag.id">
                            <a :href="tagUrl(tag.id)"
                                class="px-2.5 py-1 rounded-full text-xs transition-colors no-underline"
                                :class="isActive(tag.id)
                                    ? 'bg-palacio-verde/10 text-palacio-verde border border-palacio-verde/20 font-medium'
                                    : 'bg-palacio-bege/30 text-palacio-escuro/60 border border-transparent hover:bg-palacio-bege/50 hover:border-palacio-bege'"
                                x-text="tag.nome">
                            </a>
                        </template>
                    </div>

                    {{-- Ver mais / menos --}}
                    <template x-if="hasMore && !search">
                        <button type="button" @click="expanded = !expanded"
                            class="mt-2 text-xs text-palacio-roxo/60 hover:text-palacio-roxo transition-colors"
                            x-text="expanded ? 'Ver menos tags ↑' : 'Ver mais tags ↓'">
                        </button>
                    </template>
                </div>
                @endif
            </form>
        </div>

        {{-- Grid de Projetos --}}
        @if($projetos->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($projetos as $projeto)
            <a href="{{ route('projetos.show', $projeto) }}" class="card group flex flex-col">
                {{-- Card Header: cor de categoria --}}
                <div class="h-2 rounded-t-xl {{ $projeto->categoria ? 'bg-palacio-verde' : 'bg-palacio-roxo/30' }}"></div>

                <div class="p-5 flex-1 flex flex-col">
                    {{-- Título --}}
                    <h3 class="font-serif text-lg text-palacio-roxo group-hover:text-palacio-verde transition-colors line-clamp-2">
                        {{ $projeto->titulo }}
                    </h3>

                    {{-- Excerpt descrição --}}
                    <p class="mt-2 text-sm text-palacio-escuro/60 line-clamp-3 flex-1">
                        {{ Str::limit($projeto->descricao, 120) }}
                    </p>

                    {{-- Tags --}}
                    @if($projeto->tags->count())
                    <div class="flex flex-wrap gap-1.5 mt-3">
                        @foreach($projeto->tags->take(3) as $tag)
                        <span class="chip text-[10px] !px-2 !py-0.5">{{ $tag->nome }}</span>
                        @endforeach
                        @if($projeto->tags->count() > 3)
                        <span class="text-xs text-palacio-roxo/50">+{{ $projeto->tags->count() - 3 }}</span>
                        @endif
                    </div>
                    @endif

                    {{-- Footer do card --}}
                    <div class="flex items-center justify-between mt-4 pt-3 border-t border-palacio-bege/60">
                        {{-- Autor --}}
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

                        {{-- Badge categoria + curtidas --}}
                        <div class="flex items-center space-x-2">
                            @if($projeto->categoria)
                            <span class="text-[10px] bg-palacio-verde/10 text-palacio-verde px-2 py-0.5 rounded-full font-medium">
                                {{ $projeto->categoria->nome }}
                            </span>
                            @endif
                            <span class="text-xs text-palacio-roxo/50 flex items-center space-x-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                <span>{{ $projeto->curtidas->count() }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Paginação --}}
        <div class="mt-10">
            {{ $projetos->withQueryString()->links() }}
        </div>
        @else
        {{-- Empty state --}}
        <div class="text-center py-20">
            <div class="text-6xl mb-4 opacity-30">&#x1F3DB;</div>
            <h2 class="font-serif text-xl text-palacio-roxo/60">Nenhum projeto encontrado</h2>
            <p class="mt-2 text-sm text-palacio-escuro/40">Seja o primeiro a compartilhar seu trabalho!</p>
            @auth
            <a href="{{ route('projetos.create') }}" class="btn-primary inline-block mt-6">
                Criar Projeto
            </a>
            @else
            <a href="{{ route('register') }}" class="btn-primary inline-block mt-6">
                Cadastre-se
            </a>
            @endauth
        </div>
        @endif
    </div>
</x-app-layout>
