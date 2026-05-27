<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="font-serif text-2xl text-palacio-roxo mb-6">
            Editar Projeto
        </h1>

        <form method="POST" action="{{ route('projetos.update', $projeto) }}" id="projetoForm">
            @csrf @method('PUT')

            {{-- Título --}}
            <div class="mb-5">
                <x-input-label for="titulo" :value="'Título'" class="text-palacio-roxo font-serif" />
                <x-text-input id="titulo" name="titulo" type="text" value="{{ old('titulo', $projeto->titulo) }}"
                    class="mt-1 block w-full" />
                <p class="text-xs text-palacio-escuro/40 mt-1">Mínimo 3, máximo 100 caracteres.</p>
                <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
            </div>

            {{-- Descrição --}}
            <div class="mb-5">
                <x-input-label for="descricao" :value="'Descrição'" class="text-palacio-roxo font-serif" />
                <textarea id="descricao" name="descricao" rows="6"
                    class="mt-1 block w-full rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30">{{ old('descricao', $projeto->descricao) }}</textarea>
                <p class="text-xs text-palacio-escuro/40 mt-1">Mínimo 10, máximo 5000 caracteres.</p>
                <x-input-error :messages="$errors->get('descricao')" class="mt-2" />
            </div>

            {{-- Status + Categoria --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div>
                    <x-input-label for="status" :value="'Status'" class="text-palacio-roxo font-serif" />
                    <select id="status" name="status"
                        class="mt-1 block w-full rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30">
                        <option value="rascunho" {{ old('status', $projeto->status) === 'rascunho' ? 'selected' : '' }}>Rascunho</option>
                        <option value="publico" {{ old('status', $projeto->status) === 'publico' ? 'selected' : '' }}>Público</option>
                        <option value="privado" {{ old('status', $projeto->status) === 'privado' ? 'selected' : '' }}>Privado</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="categoria_id" :value="'Categoria'" class="text-palacio-roxo font-serif" />
                    <select id="categoria_id" name="categoria_id"
                        class="mt-1 block w-full rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30">
                        <option value="" disabled {{ old('categoria_id', $projeto->categoria_id) ? '' : 'selected' }}>Selecione a área...</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $projeto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nome }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
                </div>
            </div>

            {{-- Tags com chips clicáveis --}}
            <div class="mb-5" x-data="{
                search: '',
                selected: {{ json_encode(old('tags', $projeto->tags->pluck('id')->map(fn($id) => (int) $id)->toArray())) }},
                allTags: {{ $tags->map(fn($t) => ['id' => $t->id, 'nome' => $t->nome])->values()->toJson() }},
                maxTags: 5,
                get filtered() {
                    return this.allTags.filter(t =>
                        t.nome.toLowerCase().includes(this.search.toLowerCase())
                    );
                },
                toggle(id) {
                    if (this.selected.includes(id)) {
                        this.selected = this.selected.filter(i => i !== id);
                    } else if (this.selected.length < this.maxTags) {
                        this.selected.push(id);
                    }
                },
                isSelected(id) {
                    return this.selected.includes(id);
                },
                isFull() {
                    return this.selected.length >= this.maxTags;
                }
            }">
                <x-input-label :value="'Tags'" class="text-palacio-roxo font-serif" />

                {{-- Selected tags como chips --}}
                <div class="flex flex-wrap gap-2 mt-2 mb-3">
                    <template x-for="id in selected" :key="id">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-palacio-verde/10 text-palacio-verde border border-palacio-verde/20">
                            <span x-text="allTags.find(t => t.id === id)?.nome"></span>
                            <button type="button" @click="toggle(id)" class="hover:text-palacio-roxo transition-colors">&times;</button>
                        </span>
                    </template>
                    <span class="text-xs text-palacio-escuro/40 self-center"
                          x-text="selected.length + '/' + maxTags + ' tags'"></span>
                </div>

                {{-- Busca + lista --}}
                <input type="text" x-model="search"
                    class="w-full rounded-lg border border-palacio-bege bg-palacio-claro text-sm px-3 py-2 focus:border-palacio-verde focus:ring-palacio-verde/30"
                    placeholder="Buscar tags..."
                    :class="{ 'opacity-50 cursor-not-allowed': isFull() }"
                    :disabled="isFull()" />

                <div class="flex flex-wrap gap-1.5 mt-2 max-h-40 overflow-y-auto">
                    <template x-for="tag in filtered" :key="tag.id">
                        <button type="button" @click="toggle(tag.id)"
                            class="px-2.5 py-1 rounded-full text-xs transition-colors"
                            :class="isSelected(tag.id)
                                ? 'bg-palacio-verde/10 text-palacio-verde border border-palacio-verde/20'
                                : (isFull() ? 'bg-gray-100 text-gray-400 border border-gray-200 cursor-not-allowed' : 'bg-palacio-bege/30 text-palacio-escuro/60 border border-palacio-bege/60 hover:bg-palacio-bege/50')"
                            :disabled="!isSelected(tag.id) && isFull()">
                            <span x-text="tag.nome"></span>
                        </button>
                    </template>
                </div>

                {{-- Hidden inputs para submit --}}
                <template x-for="id in selected" :key="'tag-'+id">
                    <input type="hidden" name="tags[]" :value="id">
                </template>

                @if($errors->has('tags'))
                    <p class="text-xs text-red-500 mt-2">{{ $errors->first('tags') }}</p>
                @endif
                @if($errors->has('tags.*'))
                    <p class="text-xs text-red-500 mt-2">{{ $errors->first('tags.*') }}</p>
                @endif
            </div>

            {{-- Mídias existentes --}}
            @if($projeto->midias->count())
                <div class="mb-5">
                    <x-input-label :value="'Mídias existentes'" class="text-palacio-roxo font-serif" />
                    <div class="mt-2 space-y-2">
                        @foreach($projeto->midias as $midia)
                            <div class="flex items-center space-x-2 bg-palacio-claro p-2 rounded-lg">
                                <span class="text-[10px] bg-palacio-verde/10 text-palacio-verde px-2 py-0.5 rounded-full">{{ $midia->tipo }}</span>
                                <span class="text-sm text-palacio-escuro/60 truncate flex-1">{{ $midia->url }}</span>
                                <label class="flex items-center space-x-1 text-xs text-red-400 cursor-pointer">
                                    <input type="checkbox" name="remover_midias[]" value="{{ $midia->id }}" class="rounded border-palacio-bege text-red-500 focus:ring-red-300">
                                    <span>Remover</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Novas URLs de mídia --}}
            <div class="mb-8" x-data="{ urls: [], newUrl: '', newTipo: 'link' }">
                <x-input-label :value="'Adicionar mídias'" class="text-palacio-roxo font-serif" />
                <p class="text-xs text-palacio-escuro/40 mb-2">Links, imagens, vídeos ou áudios. Máximo 5 novas.</p>

                <div class="mt-2 space-y-2">
                    <template x-for="(url, index) in urls" :key="index">
                        <div class="flex items-center space-x-2">
                            <input type="text" x-model="urls[index]" name="novas_midias[]"
                                class="flex-1 rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30">
                            <select name="novas_midia_tipos[]"
                                class="rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30">
                                <option value="link">Link</option>
                                <option value="imagem">Imagem</option>
                                <option value="video">Vídeo</option>
                                <option value="audio">Áudio</option>
                            </select>
                            <button type="button" @click="urls.splice(index, 1)" class="text-red-400 hover:text-red-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </template>
                </div>

                <div class="mt-3 flex items-center space-x-2">
                    <input type="text" x-model="newUrl"
                        class="flex-1 rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30"
                        placeholder="https://..." @keydown.enter.prevent="$el.nextElementSibling?.focus()">
                    <select x-model="newTipo"
                        class="rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30">
                        <option value="link">Link</option>
                        <option value="imagem">Imagem</option>
                        <option value="video">Vídeo</option>
                        <option value="audio">Áudio</option>
                    </select>
                    <button type="button" @click="if(newUrl.trim()) { urls.push(newUrl.trim()); newUrl = ''; }"
                        class="btn-outline text-xs py-1.5 px-3"
                        :class="{ 'opacity-50 cursor-not-allowed': urls.length >= 5 }"
                        :disabled="urls.length >= 5">
                        + Adicionar
                    </button>
                </div>

                @error('novas_midias')
                    <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                @enderror
                @error('novas_midias.*')
                    <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center space-x-3">
                <button type="submit"
                    onclick="document.getElementById('status_hidden').value = 'rascunho'"
                    class="btn-outline">
                    Salvar Rascunho
                </button>
                <button type="submit"
                    onclick="document.getElementById('status_hidden').value = 'publico'"
                    class="btn-primary">
                    Publicar
                </button>
                <input type="hidden" id="status_hidden" name="status" value="{{ old('status', $projeto->status) }}">
            </div>
        </form>
    </div>
</x-app-layout>
