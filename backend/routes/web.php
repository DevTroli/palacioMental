<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\CurtidaController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalvoController;
use Illuminate\Support\Facades\Route;

// Públicas
Route::get('/', [FeedController::class, 'index'])->name('feed');
Route::get('/dashboard', function () { return redirect()->route('feed'); })->name('dashboard');
Route::get('/projetos', [ProjetoController::class, 'index'])->name('projetos.index');
Route::get('/projetos/{projeto}', [ProjetoController::class, 'show'])->name('projetos.show');
Route::get('/u/{username}', [PerfilController::class, 'show'])->name('perfil.show');

// Autenticadas
Route::middleware('auth')->group(function () {
    Route::resource('projetos', ProjetoController::class)->except(['index', 'show']);
    Route::post('/projetos/{projeto}/curtir', [CurtidaController::class, 'toggle'])->name('curtidas.toggle');
    Route::post('/projetos/{projeto}/salvar', [SalvoController::class, 'toggle'])->name('salvos.toggle');
    Route::post('/projetos/{projeto}/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
