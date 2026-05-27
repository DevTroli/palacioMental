<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl sm:text-3xl font-serif text-palacio-roxo tracking-wide mb-8">
            Editar Projeto
        </h1>

        <form method="POST" action="{{ route('projetos.update', $projeto) }}" id="projetoForm">
            @csrf @method('PUT')

            {{-- Título --}}
            <div class="mb-5">
                <x-input-label for="titulo" :value="'T&iacute;tulo'" class="text-palacio-roxo font-serif" />
                <x-text-input id="titulo" name="titulo" type="text" value="{{ old('titulo', $projeto->titulo) }}"
                    class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
            </div>

            {{-- Descrição --}}
            <div class="mb-5">
                <x-input-label for="descricao" :value="'Descri&ccedil;&atilde;o'" class="text-palacio-roxo font-serif" />
                <textarea id="descricao" name="descricao" rows="6"
                    class="mt-1 block w-full rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30">{{ old('descricao', $projeto->descricao) }}</textarea>
                <x-input-error :messages="$errors->get('descricao')" class="mt-2" />
            </div>

            {{-- Status + Categoria --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div>
                    <x-input-label for="status" :value="'Status'" class="text-palacio-roxo font-serif" />
                    <select id="status" name="status"
                        class="mt-1 block w-full rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30">
                        <option value="rascunho" {{ old('status', $projeto->status) === 'rascunho' ? 'selected' : '' }}>Rascunho</option>
                        <option value="publico" {{ old('status', $projeto->status) === 'publico' ? 'selected' : '' }}>P&uacute;blico</option>
                        <option value="privado" {{ old('status', $projeto->status) === 'privado' ? 'selected' : '' }}>Privado</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="categoria_id" :value="'Categoria'" class="text-palacio-roxo font-serif" />
                    <select id="categoria_id" name="categoria_id"
                        class="mt-1 block w-full rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30">
                        <option value="">Sem categoria</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ old('categoria_id', $projeto->categoria_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nome }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
                </div>
            </div>

            {{-- Tags --}}
            <div class="mb-5">
                <x-input-label for="tags" :value="'Tags'" class="text-palacio-roxo font-serif" />
                <p class="text-xs text-palacio-escuro/40 mb-2">Segure Ctrl/Cmd para selecionar m&uacute;ltiplas</p>
                @php
                    $selectedTags = old('tags', $projeto->tags->pluck('id')->toArray());
                @endphp
                <select id="tags" name="tags[]" multiple
                    class="mt-1 block w-full rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30 h-32">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}>
                            {{ $tag->nome }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('tags')" class="mt-2" />
            </div>

            {{-- Mídias existentes --}}
            @if($projeto->midias->count())
                <div class="mb-5">
                    <x-input-label :value="'M&iacute;dias existentes'" class="text-palacio-roxo font-serif" />
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
            <div class="mb-8" x-data="{ urls: [], newUrl: '' }">
                <x-input-label :value="'Adicionar m&iacute;dias'" class="text-palacio-roxo font-serif" />

                <div class="mt-2 space-y-2">
                    <template x-for="(url, index) in urls" :key="index">
                        <div class="flex items-center space-x-2">
                            <input type="text" x-model="urls[index]" name="novas_midias[]"
                                class="flex-1 rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30">
                            <select name="novas_midia_tipos[]"
                                class="rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30">
                                <option value="link">Link</option>
                                <option value="imagem">Imagem</option>
                                <option value="video">V&iacute;deo</option>
                                <option value="audio">&Aacute;udio</option>
                            </select>
                            <button type="button" @click="urls.splice(index, 1)" class="text-red-400 hover:text-red-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </template>
                </div>

                <div class="flex items-center space-x-2 mt-3">
                    <input type="text" x-model="newUrl"
                        class="flex-1 rounded-lg border-palacio-bege bg-palacio-claro text-sm focus:border-palacio-verde focus:ring-palacio-verde/30"
                        placeholder="Cole uma URL..." @keydown.enter.prevent="if(newUrl.trim()) { urls.push(newUrl.trim()); newUrl = '' }">
                    <button type="button" @click="if(newUrl.trim()) { urls.push(newUrl.trim()); newUrl = '' }"
                        class="btn-outline !text-sm !py-1.5 text-palacio-verde border-palacio-verde/40 hover:bg-palacio-verde/10">
                        + Adicionar
                    </button>
                </div>
            </div>

            {{-- Botões --}}
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-palacio-bege/60">
                <a href="{{ route('projetos.show', $projeto) }}" class="btn-outline text-palacio-roxo/60 border-palacio-roxo/20 hover:bg-palacio-roxo/5">
                    Cancelar
                </a>
                <button type="submit" name="status" value="rascunho"
                    onclick="document.getElementById('status_hidden').value = 'rascunho'"
                    class="btn-outline text-palacio-roxo border-palacio-roxo/30 hover:bg-palacio-roxo/5">
                    Salvar Rascunho
                </button>
                <button type="submit" name="status" value="publico"
                    onclick="document.getElementById('status_hidden').value = 'publico'"
                    class="btn-primary">
                    Publicar
                </button>
                <input type="hidden" id="status_hidden" name="status" value="{{ old('status', $projeto->status) }}">
            </div>
        </form>
    </div>
</x-app-layout>
