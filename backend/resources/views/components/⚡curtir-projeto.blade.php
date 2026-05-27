<?php

use App\Models\Projeto;
use Livewire\Component;

new class extends Component
{
    public Projeto $projeto;
    public bool $curtido;
    public int $totalCurtidas;

    public function mount(): void
    {
        $this->curtido = auth()->check()
            && $this->projeto->curtidas()->where('user_id', auth()->id())->exists();
        $this->totalCurtidas = $this->projeto->curtidas()->count();
    }

    public function toggle(): void
    {
        if (! auth()->check()) {
            $this->redirectRoute('login');
            return;
        }

        $this->projeto->curtidas()->toggle([auth()->id()]);
        $this->curtido = ! $this->curtido;
        $this->totalCurtidas = $this->projeto->curtidas()->count();
    }
};
?>

<div>
    <button wire:click="toggle"
            class="flex items-center space-x-1.5 group transition-colors {{ $curtido ? 'text-red-500' : 'text-palacio-roxo/50 hover:text-red-400' }}">
        <svg class="w-5 h-5 {{ $curtido ? 'fill-current' : 'fill-none stroke-current stroke-2' }}" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
        <span class="text-sm font-medium">{{ $totalCurtidas }}</span>
    </button>
</div>
