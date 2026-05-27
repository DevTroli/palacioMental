@props(['projeto'])

@auth
    @php
        $curtido = $projeto->curtidas->contains(auth()->id());
    @endphp

    <form action="{{ route('curtidas.toggle', $projeto) }}" method="POST" class="inline-block">
        @csrf
        <button type="submit"
                class="flex items-center space-x-1.5 px-3 py-1.5 rounded-full text-sm transition-colors
                       {{ $curtido
                           ? 'bg-red-50 text-red-500 hover:bg-red-100'
                           : 'bg-palacio-bege text-palacio-escuro/60 hover:bg-palacio-bege/80' }}">
            <svg class="w-5 h-5 {{ $curtido ? 'fill-current' : '' }}" fill="{{ $curtido ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <span>{{ $projeto->curtidas->count() }}</span>
        </button>
    </form>
@else
    <span class="flex items-center space-x-1.5 px-3 py-1.5 rounded-full text-sm bg-palacio-bege text-palacio-escuro/60">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
        <span>{{ $projeto->curtidas->count() }}</span>
    </span>
@endauth
