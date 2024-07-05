<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;


Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/', [ProfileController::class, 'index'])->name('index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Avaliações
    Route::get('/avaliacoes/painel', [AvaliacaoController::class, 'read'])->name('avaliacoes.painel');
    Route::get('/avaliacoes/nova_avaliacao', [AvaliacaoController::class, 'create'])->name('avaliacoes.create');
    Route::get('/avaliacoes/details_avaliacao/{id}', [AvaliacaoController::class, 'details']);
    Route::post('/avaliacoes', [AvaliacaoController::class, 'store'])->name('avaliacoes.store');
    
    //Notificações
    Route::get('/avaliacoes/notificacao', [NotificationController::class, 'index'])->name('avaliacoes.notificacao');



    //Usuario
    Route::get('/user/details_user', [UserController::class, 'read']);
});

require __DIR__ . '/auth.php';
