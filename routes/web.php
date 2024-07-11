<?php

use App\Jobs\TranscreverAudio;

use App\Models\Avaliacoe;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

use App\Http\Middleware\CheckCoordinator;


Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);


Route::get('/', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('index');

Route::middleware('auth')->group(function () {

    Route::get('/', [ProfileController::class, 'index'])->name('index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Avaliações
    Route::get('/avaliacoes/painel', [AvaliacaoController::class, 'read'])->name('avaliacoes.painel');
    Route::get('/avaliacoes/nova_avaliacao', [AvaliacaoController::class, 'create'])->name('avaliacoes.create');
    Route::get('/avaliacoes/details_avaliacao/{id}', [AvaliacaoController::class, 'details'])->name('avaliacoes.details_avaliacao');
    Route::post('/avaliacoes', [AvaliacaoController::class, 'store'])->name('avaliacoes.store');
    Route::delete('/avaliacoes/{id}', [AvaliacaoController::class, 'destroy'])->name('avaliacoes.destroy');
    Route::put('/avaliacoes/{id}', [AvaliacaoController::class, 'update'])->name('avaliacoes.update');

    //Notificações
    Route::get('/avaliacoes/notificacao', [NotificationController::class, 'index'])->name('avaliacoes.notificacao');

    //Usuario
    Route::get('/user/user_details', [UserController::class, 'read'])->name('user.user_details');
    Route::get('/user/update_user', [UserController::class, 'update'])->name('user.update_user');
    Route::get('/user/painel_user', [UserController::class, 'index'])->name('user.painel_user');
    Route::get('/user/painel_user_details/{id}', [UserController::class, 'details'])->name('user.painel_user_details');
    Route::put('/user/painel_user_details/update/{id}', [UserController::class, 'updateUser'])->name('user.updateUser');
    Route::put('/user/painel_user_details/update-name/{id}', [UserController::class, 'updateName'])->name('user.updateName');
    Route::get('/cliente', [ClienteController::class, 'index'])->name('cliente.index');
    Route::post('/cliente', [ClienteController::class, 'store'])->name('cliente.store');
    Route::delete('/cliente/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');

});

//Acesso limitado aos coordenadores
Route::middleware(['auth', CheckCoordinator::class])->group(function () {

    //Usuarios


    //Clientes
});

require __DIR__ . '/auth.php';
