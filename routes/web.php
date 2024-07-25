<?php

//Controllers
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\HomeController;


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
        Route::get('/panel', [EvaluationController::class, 'index'])->name('evaluations.panel');
        Route::post('/', [EvaluationController::class, 'store'])->name('evaluations.store');
        Route::get('/new_evaluation', [EvaluationController::class, 'create'])->name('evaluations.create');
        Route::put('/{id}', [EvaluationController::class, 'update'])->name('evaluations.update');
        Route::delete('/{id}', [EvaluationController::class, 'destroy'])->name('evaluations.destroy');
        Route::get('/details_evaluation/{id}', [EvaluationController::class, 'details'])->name('evaluations.details_evaluation');
        Route::post('/salvar/{id}', [EvaluationController::class, 'salvarAvaliacao'])->name('salvar_avaliacao');
        Route::get('/details/{id}', [EvaluationController::class, 'detailsAvaliar'])->name('evaluations.details_avaliar');
        Route::get('/avaliar', [EvaluationController::class, 'evaluation'])->name('evaluations.avaliacao');
        Route::get('/avaliar/{id}', [EvaluationController::class, 'avaliar'])->name('evaluations.avaliar');
    });

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notification/reading/{id}', [NotificationController::class, 'markReading'])->name('notification.reading');
    });
    
    Route::prefix('users')->group(function () {
        Route::get('/user', [UserController::class, 'read'])->name('users.user');

    });
    


    });
    
    // Rotas acessíveis apenas para coordenadores
Route::middleware(['auth', AccessLevel::class])->group(function () {


    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    
    Route::prefix('evaluations')->group(function (){
        Route::get('/questionnaire/{id}', [EvaluationController::class, 'question'])->name('evaluations.questionnaire');
        Route::post('/questionnaire/{id}', [EvaluationController::class, 'questionSave'])->name('evaluations.save');

    });
    // Rotas de Usuário
    Route::prefix('users')->group(function () {
        Route::get('/users/panel', [UserController::class, 'index'])->name('users.panel_users');
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/users_details/{id}', [UserController::class, 'index'])->name('users.users_details_index');
        Route::get('/update_user', [UserController::class, 'update'])->name('users.update_user');
        Route::get('/update_password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
        Route::get('/panel_user_details/{id}', [UserController::class, 'details'])->name('users.panel_users_details');
        Route::put('/panel_user_details/updateUser/{id}', [UserController::class, 'updateUser'])->name('users.updateUser');
        Route::put('/panel_user_details/updateName/{id}', [UserController::class, 'updateName'])->name('users.updateName');
    });
    // Rotas de Questionário 
    // Route::prefix('questionnaires')->group(function () {
    //     Route::get('/panel', [QuestionnaireController::class, 'index'])->name('questionnaires.index');
    //     Route::get('/form', [QuestionnaireController::class, 'formQuestion'])->name('questionnaires.form');
    //     Route::post('/form', [QuestionnaireController::class, 'store'])->name('questionnaires.store');
    //     Route::get('/{questionnaire}/edit', [QuestionnaireController::class, 'editarPergunta'])->name('questionnaires.edit');
    //     Route::put('/{questionnaire}', [QuestionnaireController::class, 'updatePergunta'])->name('questionnaires.update');
    //     Route::delete('/{questionnaire}', [QuestionnaireController::class, 'deletePergunta'])->name('questionnaires.delete');
    
    // });
    
    Route::prefix('questionnaires')->group(function () {
        Route::get('/panel', [QuestionController::class, 'index'])->name('questionnaires.index');
        Route::get('/form', [QuestionController::class, 'form'])->name('questionnaires.form');
        Route::post('/form', [QuestionController::class, 'store'])->name('questionnaires.store');
        Route::get('/form/{id}', [QuestionController::class, 'editQuestion'])->name('questionnaires.edit');
        Route::put('/form/{id}', [QuestionController::class, 'updatePergunta'])->name('questionnaires.update');
        Route::delete('/{id}', [QuestionController::class, 'destroy'])->name('questionnaires.delete');
    });

    // Rotas de Clientes
    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('clients.index');
        Route::post('/', [ClientController::class, 'store'])->name('clients.store'); 
        Route::delete('/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
        Route::put('/{id}', [ClientController::class, 'update'])->name('clients.update');
    });
});

// Inclui as rotas de autenticação do Laravel
require __DIR__ . '/auth.php';
