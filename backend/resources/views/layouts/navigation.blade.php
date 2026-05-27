<nav x-data="{ open: false }" class="bg-palacio-roxoescuro shadow-lg">
    <!-- Desktop -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24 items-center">
            <!-- Logo + Feed -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('feed') }}" class="flex items-center space-x-2 group">
                    <img src="https://servidor-estaticos-ashy.vercel.app/v2/palaciomental/palaciomental.png"
                         alt="Logo Palácio Mental"
                         onerror="this.onerror=null;this.src='/palaciomental.png';"
                         class="w-24 h-24 rounded-lg object-contain group-hover:opacity-80 transition-opacity">
                    <span class="text-white font-serif text-lg tracking-wide hidden sm:inline">
                        Palácio Mental
                    </span>
                </a>

                <a href="{{ route('feed') }}"
                   class="text-white/80 hover:text-white font-serif text-sm tracking-wider transition-colors {{ request()->routeIs('feed') ? 'text-white border-b-2 border-palacio-laranja' : '' }}">
                    Feed
                </a>
            </div>

            <!-- Auth Desktop -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                @auth
                    <a href="{{ route('projetos.create') }}"
                       class="btn-outline text-white border-white/40 hover:bg-white/10 hover:text-white text-xs !py-1.5 !px-3">
                        + Novo Projeto
                    </a>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center space-x-2 text-white/80 hover:text-white transition-colors focus:outline-none">
                                @if(auth()->user()->avatar_url)
                                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover border-2 border-white/30">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-palacio-verde flex items-center justify-center text-white text-xs font-serif font-bold">
                                        {{ strtoupper(auth()->user()->name[0]) }}
                                    </div>
                                @endif
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="auth()->user()->username ? route('perfil.show', auth()->user()->username) : route('profile.edit')">
                                Meu Palácio
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">
                                Configurações
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Sair
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-white/80 hover:text-white font-serif text-sm transition-colors">
                        Entrar
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary !text-xs !py-1.5">
                        Cadastrar
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="text-white/80 hover:text-white p-2 rounded-md focus:outline-none transition-colors">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-palacio-roxoescuro border-t border-white/10">
        <div class="px-4 pt-3 pb-2 space-y-1">
            <a href="{{ route('feed') }}" class="block text-white/80 hover:text-white font-serif py-2">Feed</a>
            @auth
                <a href="{{ route('projetos.create') }}" class="block text-white/80 hover:text-white font-serif py-2">Novo Projeto</a>
                <a href="{{ auth()->user()->username ? route('perfil.show', auth()->user()->username) : route('profile.edit') }}" class="block text-white/80 hover:text-white font-serif py-2">Meu Palácio</a>
            @endauth
        </div>

        @auth
            <div class="px-4 pb-3 border-t border-white/10 pt-3 space-y-1">
                <div class="flex items-center space-x-3 mb-2">
                    @if(auth()->user()->avatar_url)
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                    @else
                        <div class="w-8 h-8 rounded-full bg-palacio-verde flex items-center justify-center text-white text-xs font-serif font-bold">
                            {{ strtoupper(auth()->user()->name[0]) }}
                        </div>
                    @endif
                    <span class="text-white font-serif text-sm">{{ auth()->user()->name }}</span>
                </div>
                <a href="{{ route('profile.edit') }}" class="block text-white/70 hover:text-white text-sm py-1">Configurações</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block text-white/70 hover:text-white text-sm py-1 w-full text-left">Sair</button>
                </form>
            </div>
        @else
            <div class="px-4 pb-3 space-y-2">
                <a href="{{ route('login') }}" class="block text-center text-white/80 hover:text-white font-serif py-2 border border-white/30 rounded-lg">Entrar</a>
                <a href="{{ route('register') }}" class="block text-center btn-primary py-2">Cadastrar</a>
            </div>
        @endauth
    </div>
</nav>
