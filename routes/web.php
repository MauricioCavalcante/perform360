<?php

//Controllers
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\WarningController;


//Middleware
use App\Http\Middleware\AccessLevel;
use Illuminate\Support\Facades\Route;

Route::get('admin/register', [RegisteredUserController::class, 'createAdmin'])->name('register_admin');
Route::post('admin/register', [RegisteredUserController::class, 'storeAdmin'])->name('store_admin');




Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('index');
    })->middleware(['auth', 'verified'])->name('index');

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/profile/update-password', [PasswordController::class, 'index'])->name('profile.update-password');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de Avaliações
    Route::prefix('evaluations')->group(function () {
        Route::get('/', [EvaluationController::class, 'index'])->name('evaluations.index');
        Route::post('/create', [EvaluationController::class, 'store'])->name('evaluations.store');
        Route::get('/new_evaluation', [EvaluationController::class, 'create'])->name('evaluations.create');
        Route::put('/{id}', [EvaluationController::class, 'update'])->name('evaluations.update');
        Route::delete('/{id}', [EvaluationController::class, 'destroy'])->name('evaluations.destroy');
        Route::get('/details_evaluation/{id}', [EvaluationController::class, 'details'])->name('evaluations.details_evaluation');
        Route::get('/details_questionnaire/{id}', [EvaluationController::class, 'showEvaluationDetails'])->name('evaluations.details_questionnaire');
        Route::post('/{id}/revision', [EvaluationController::class, 'revision'])->name('evaluation.revision');
        Route::post('/{evaluationId}/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/comments/{commentId}', [CommentController::class, 'destroy'])->name('comments.delete');
    
    });

    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notification/reading/{id}', [NotificationController::class, 'markReading'])->name('notification.reading');
    });

    Route::prefix('users')->group(function () {
        Route::get('/user', [UserController::class, 'read'])->name('users.user');
    });

    Route::prefix('procedures')->group(function(){
        Route::get('/', [ProcedureController::class, 'index'])->name('procedures.index');
    });

    Route::prefix('warnings')->group(function(){
        Route::get('/', [WarningController::class, 'index'])->name('warnings.index');
    });
});

// Rotas acessíveis apenas para coordenadores
Route::middleware(['auth', AccessLevel::class])->group(function () {

    // Registar usuário como coordenador
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Rotas de Avaliações
    Route::prefix('evaluations')->group(function () {
        Route::get('/questionnaire/{id}', [QuestionController::class, 'questionnaire'])->name('questionnaires.questionnaire');
        Route::post('/questionnaire/{id}', [QuestionController::class, 'questionnaireSave'])->name('questionnaires.save');
        Route::post('/evaluations/{evaluationId}/questions', [QuestionController::class, 'questionnaireUpdate'])->name('questionnaires.update');

    });
    // Rotas de Usuários
    Route::prefix('users')->group(function () {
        Route::get('/users/panel', [UserController::class, 'index'])->name('users.panel_users');
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/users_details/{id}', [UserController::class, 'index'])->name('users.users_details_index');
        Route::get('/update_user', [UserController::class, 'update'])->name('users.update_user');
        Route::get('/update_password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
        Route::get('/panel_user_details/{id}', [UserController::class, 'details'])->name('users.panel_users_details');
        Route::put('/panel_user_details/updateUser/{id}', [UserController::class, 'updateUser'])->name('users.updateUser');
        Route::put('/panel_user_details/updateName/{id}', [UserController::class, 'updateName'])->name('users.updateName');
        Route::delete('/panel_user_details/{id}', [UserController::class, 'destroy'])->name('users.delete');
    });

    // Rotas de Questionarios
    Route::prefix('questionnaires')->group(function () {
        Route::get('/', [QuestionController::class, 'index'])->name('questionnaires.index');
        Route::get('/form', [QuestionController::class, 'form'])->name('questions.form');
        Route::post('/form', [QuestionController::class, 'store'])->name('questions.store');
        Route::get('/form/{id}/edit', [QuestionController::class, 'editQuestion'])->name('questions.edit');
        Route::put('/form/{id}', [QuestionController::class, 'updateQuestion'])->name('questions.update');
        Route::delete('/{id}', [QuestionController::class, 'destroy'])->name('questions.delete');
    });

    // Rotas de Clientes
    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('clients.index');
        Route::post('/', [ClientController::class, 'store'])->name('clients.store');
        Route::delete('/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
        Route::put('/{id}', [ClientController::class, 'update'])->name('clients.update');
    });

    Route::prefix('warnings')->group(function(){
        Route::get('/create', [WarningController::class, 'create'])->name('warnings.create');
        Route::post('/store', [WarningController::class, 'store'])->name('warnings.store');
        Route::get('/panel', [WarningController::class, 'panel'])->name('warnings.panel');
        Route::put('/{id}', [WarningController::class, 'update'])->name('warnings.update');
        Route::delete('/{id}', [WarningController::class, 'delete'])->name('warnings.destroy');
    });

    Route::prefix('procedures')->group(function(){
        Route::put('/update', [ProcedureController::class, 'update'])->name('procedures.update');
    });
});

// Inclui as rotas de autenticação do Laravel
require __DIR__ . '/auth.php';
