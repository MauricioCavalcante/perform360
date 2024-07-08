<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionarioController;


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

    //Chamados
    Route::get('/avaliacoes/painel', [AvaliacaoController::class, 'read'])->name('avaliacao.painel');
    Route::get('/avaliacoes/nova_avaliacao', [AvaliacaoController::class, 'store'])->name('avaliacao.nova');
    Route::get('/avaliacoes/details_avaliacao/{id}', [AvaliacaoController::class, 'details'])->name('avaliacao.detalhes');

    //Usuario
    Route::get('/user/details_user', [UserController::class, 'read']);

    //Questionario
    // Rota para a página inicial dos questionários, onde as perguntas cadastradas serão listadas
    Route::get('/questionarios', [QuestionarioController::class, 'index'])->name('questionarios.index');
    // Rota para o formulário de criação de uma nova pergunta
    Route::get('/questionarios/create', [QuestionarioController::class, 'cadastrarPergunta'])->name('questionarios.create');
    // Rota para enviar os dados do formulário de criação de uma nova pergunta
    Route::post('/questionarios', [QuestionarioController::class, 'salvarPergunta'])->name('questionarios.store');
    // Rota para editar os dados do formulário de criação de uma nova pergunta
    Route::get('/questionarios/{questionario}/edit', [QuestionarioController::class, 'editarPergunta'])->name('questionarios.edit');
    // Rota para atualizar os dados do formulário de criação de uma nova pergunta
    Route::put('/questionarios/{questionario}', [QuestionarioController::class, 'updatePergunta'])->name('questionarios.update');
    // Rota para deletar os dados do formulário de criação de uma nova pergunta
    Route::delete('/questionarios/{questionario}', [QuestionarioController::class, 'deletePergunta'])->name('questionarios.delete');
});

require __DIR__ . '/auth.php';
