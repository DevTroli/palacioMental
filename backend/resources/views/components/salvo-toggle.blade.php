@props(['projeto'])

@auth
    @php
        $salvo = $projeto->salvos->contains(auth()->id());
    @endphp

    <form action="{{ route('salvos.toggle', $projeto) }}" method="POST" class="inline-block">
        @csrf
        <button type="submit"
                class="flex items-center space-x-1.5 px-3 py-1.5 rounded-full text-sm transition-colors
                       {{ $salvo
                           ? 'bg-palacio-roxo/10 text-palacio-roxo hover:bg-palacio-roxo/20'
                           : 'bg-palacio-bege text-palacio-escuro/60 hover:bg-palacio-bege/80' }}">
            <svg class="w-5 h-5 {{ $salvo ? 'fill-current' : '' }}" fill="{{ $salvo ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
            </svg>
            <span>Salvar</span>
        </button>
    </form>
@else
    <span class="flex items-center space-x-1.5 px-3 py-1.5 rounded-full text-sm bg-palacio-bege text-palacio-escuro/60">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
        </svg>
        <span>Salvar</span>
    </span>
@endauth
