{{-- Componente de seleção de tags como chips clicáveis com busca --}}
{{-- Props: $tags (collection), $selected (array of ids), $errors --}}
@php
    $selectedIds = $selected ?? [];
    $errorBag = $errors ?? [];
@endphp

<div x-data="{
    busca: '',
    selecionadas: {{ json_encode($selectedIds) }},
    maxTags: 5,
    todasTags: {{ $tags->map(fn($t) => ['id' => $t->id, 'nome' => $t->nome])->toJson() }},
    get filtradas() {
        if (!this.busca) return this.todasTags;
        const termo = this.busca.toLowerCase();
        return this.todasTags.filter(t => t.nome.toLowerCase().includes(termo));
    },
    toggle(id) {
        const idx = this.selecionadas.indexOf(id);
        if (idx > -1) { this.selecionadas.splice(idx, 1); }
        else if (this.selecionadas.length < this.maxTags) { this.selecionadas.push(id); }
    },
    isSelected(id) { return this.selecionadas.includes(id); }
}">
    <label class="block text-sm font-serif text-palacio-roxo mb-1">Tags</label>

    <input type="text" x-model="busca"
        placeholder="Filtrar tags..."
        class="mb-3 w-full rounded-lg border border-palacio-bege bg-palacio-claro px-3 py-2 text-sm focus:border-palacio-verde focus:ring-palacio-verde/30 placeholder:text-palacio-escuro/30" />

    {{-- Chips clicáveis --}}
    <div class="flex flex-wrap gap-2 mb-3">
        <template x-for="tag in filtradas" :key="tag.id">
            <button type="button"
                @click="toggle(tag.id)"
                :class="isSelected(tag.id)
                    ? 'bg-palacio-verde text-white border-palacio-verde'
                    : 'bg-palacio-bege/50 text-palacio-escuro/70 border-palacio-bege hover:border-palacio-verde hover:text-palacio-verde'"
                :disabled="!isSelected(tag.id) && selecionadas.length >= maxTags"
                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium border transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                <span x-text="tag.nome"></span>
                <span x-show="isSelected(tag.id)" class="ml-1">&times;</span>
            </button>
        </template>
    </div>

    {{-- Contador + resumo --}}
    <div class="flex items-center justify-between text-xs">
        <span class="text-palacio-escuro/50">
            <span x-text="selecionadas.length" :class="selecionadas.length >= maxTags ? 'text-palacio-laranja font-bold' : 'text-palacio-verde'"></span>
            /<span x-text="maxTags"></span> tags selecionadas
        </span>
        @if(count($errorBag) > 0)
            <span class="text-red-500">{{ $errorBag[0] }}</span>
        @endif
    </div>

    {{-- Hidden inputs para envio no form --}}
    <template x-for="id in selecionadas" :key="id">
        <input type="hidden" name="tags[]" :value="id">
    </template>
</div>
