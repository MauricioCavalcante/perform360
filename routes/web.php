<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionarioController;
use App\Http\Middleware\CheckCoordinator;
use Illuminate\Support\Facades\Route;

// Rotas para registro de usuário
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Rota padrão com autenticação
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('index');

    // Rotas para perfil de usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas para avaliações
    Route::prefix('/avaliacoes')->group(function () {
        Route::get('/painel', [AvaliacaoController::class, 'read'])->name('avaliacoes.painel');
        Route::get('/nova_avaliacao', [AvaliacaoController::class, 'create'])->name('avaliacoes.create');
        Route::get('/details_avaliacao/{id}', [AvaliacaoController::class, 'details'])->name('avaliacoes.details_avaliacao');
        Route::post('/', [AvaliacaoController::class, 'store'])->name('avaliacoes.store');
        Route::delete('/{id}', [AvaliacaoController::class, 'destroy'])->name('avaliacoes.destroy');
        Route::put('/{id}', [AvaliacaoController::class, 'update'])->name('avaliacoes.update');
        Route::get('/notificacao', [NotificationController::class, 'index'])->name('avaliacoes.notificacao');
    });

    // Rotas para usuário (comum)
    Route::get('/user/user_details', [UserController::class, 'read'])->name('user.user_details');
});

// Rotas com acesso limitado aos coordenadores
Route::middleware(['auth', CheckCoordinator::class])->group(function () {
    // Rotas para usuários (coordenadores)
    Route::prefix('/user')->group(function () {
        Route::get('/painel_usuarios', [UserController::class, 'viewUsuarios'])->name('user.painel_usuarios');
        Route::get('/painel_clientes', [UserController::class, 'viewClientes'])->name('user.painel_clientes');
        Route::get('/painel_questionarios', [UserController::class, 'viewQuestionarios'])->name('user.painel_questionarios');
        Route::get('/update_user', [UserController::class, 'update'])->name('user.update_user');
        Route::get('/user_details/{id}', [UserController::class, 'index'])->name('user.painel_user_details');
        Route::get('/painel_user_details/{id}', [UserController::class, 'details'])->name('user.painel_user_details.details');
        Route::put('/painel_user_details/update/{id}', [UserController::class, 'updateUser'])->name('user.updateUser');
        Route::put('/painel_user_details/update-name/{id}', [UserController::class, 'updateName'])->name('user.updateName');
    });

    // Rotas para questionários
    Route::prefix('/questionarios')->group(function () {
        Route::get('/', [QuestionarioController::class, 'index'])->name('questionarios.index');
        Route::get('/create', [QuestionarioController::class, 'cadastrarPergunta'])->name('questionarios.create');
        Route::get('/{questionario}/edit', [QuestionarioController::class, 'editarPergunta'])->name('questionarios.edit');
        Route::post('/', [QuestionarioController::class, 'store'])->name('questionarios.store');
        Route::put('/{questionario}', [QuestionarioController::class, 'updatePergunta'])->name('questionarios.update');
        Route::delete('/{questionario}', [QuestionarioController::class, 'deletePergunta'])->name('questionarios.delete');
    });

    // Rotas para clientes
    Route::prefix('/cliente')->group(function () {
        Route::get('/', [ClienteController::class, 'index'])->name('cliente.index');
        Route::post('/', [ClienteController::class, 'store'])->name('cliente.store');
        Route::delete('/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');
        Route::put('/{id}', [ClienteController::class, 'update'])->name('cliente.update');
        Route::get('/{id}', [ClienteController::class, 'show']);
    });
});

// Rotas de autenticação
require __DIR__ . '/auth.php';
