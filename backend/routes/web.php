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
Route::get('/u/{username}', [PerfilController::class, 'show'])->name('perfil.show');

// Projetos — resource completo (create/store/edit/update/destroy protegidos via controller)
Route::resource('projetos', ProjetoController::class);
Route::post('/projetos/{projeto}/curtir', [CurtidaController::class, 'toggle'])->name('curtidas.toggle')->middleware('auth');
Route::post('/projetos/{projeto}/salvar', [SalvoController::class, 'toggle'])->name('salvos.toggle')->middleware('auth');
Route::post('/projetos/{projeto}/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store')->middleware('auth');

// Autenticadas
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
