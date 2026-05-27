<?php

use App\Models\Projeto;
use Livewire\Component;

new class extends Component
{
    public Projeto $projeto;
    public bool $salvo;

    public function mount(): void
    {
        $this->salvo = auth()->check()
            && $this->projeto->salvos()->where('user_id', auth()->id())->exists();
    }

    public function toggle(): void
    {
        if (! auth()->check()) {
            $this->redirectRoute('login');
            return;
        }

        $this->projeto->salvos()->toggle([auth()->id()]);
        $this->salvo = ! $this->salvo;
    }
};
?>

<div>
    <button wire:click="toggle"
            class="flex items-center space-x-1.5 group transition-colors {{ $salvo ? 'text-palacio-laranja' : 'text-palacio-roxo/50 hover:text-palacio-laranja' }}">
        <svg class="w-5 h-5 {{ $salvo ? 'fill-current' : 'fill-none stroke-current stroke-2' }}" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
        </svg>
        <span class="text-sm font-medium">{{ $salvo ? 'Salvo' : 'Salvar' }}</span>
    </button>
</div>
