<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\PainelAdmController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacaoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\AtividadesController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\TiposController;
use App\Http\Controllers\ProfessoresController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rotas de Autenticação
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AutenticacaoController::class, 'login'])->name('login');
    Route::post('/login', [AutenticacaoController::class, 'logindo'])->name('logindo');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AutenticacaoController::class, 'logout'])->name('logout');

    // Rotas de Usuários
    Route::prefix('usuarios')->name('usuario.')->group(function () {
        Route::get('/', [UsuariosController::class, 'index'])->name('index');
        Route::get('/adicionar', [UsuariosController::class, 'adicionar'])->name('adicionar');
        Route::post('/salvar', [UsuariosController::class, 'salvar'])->name('salvar');
        Route::get('/editar/{id}', [UsuariosController::class, 'editar'])->name('editar');
        Route::post('/atualizar/{id}', [UsuariosController::class, 'atualizar'])->name('atualizar');
        Route::delete('/deletar/{id}', [UsuariosController::class, 'deletar'])->name('deletar');
    });

    // Rotas para painéis
    Route::get('/paineladm', [PainelAdmController::class, 'index'])->name('paineladm');
    Route::get('/painelprof', [ProfessoresController::class, 'index'])->name('painelprof');
    Route::get('/painelaluno', [AlunoController::class, 'index'])->name('painelaluno');

    // Rotas Admin
    Route::prefix('admin')->name('admin.')->middleware('can:isAdmin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/usuarios', [AdminController::class, 'usuariosIndex'])->name('usuarios.index');
        Route::get('/usuarios/create', [AdminController::class, 'usuariosCreate'])->name('usuarios.create');
        Route::post('/usuarios/store', [AdminController::class, 'usuariosStore'])->name('usuarios.store');
        Route::get('/usuarios/{id}/edit', [AdminController::class, 'usuariosEdit'])->name('usuarios.edit');
        Route::put('/usuarios/{id}', [AdminController::class, 'usuariosUpdate'])->name('usuarios.update');
        Route::delete('/usuarios/{id}', [AdminController::class, 'usuariosDestroy'])->name('usuarios.destroy');
        Route::get('/administrador', function () {
            return view('administrador.usuario');
        })->name('usuario.index');
    });

    // Rotas de Atividades para Administradores
    Route::prefix('atividades')->name('atividades.')->middleware('can:isAdmin')->group(function () {
        Route::get('/', [AdminController::class, 'atividadesIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'atividadesCreate'])->name('create');
        Route::post('/store', [AdminController::class, 'atividadesStore'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'atividadesEdit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'atividadesUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'atividadesDestroy'])->name('destroy');
    });

    // Rotas de Atividades para Alunos
    Route::prefix('aluno')->name('aluno.')->middleware('can:isAluno')->group(function () {
        Route::get('/atividades', [AlunoController::class, 'alunoAtividadesIndex'])->name('atividades.index');
        Route::get('/atividades/matriculadas', [AlunoController::class, 'atividadesMatriculadas'])->name('atividades.matriculadas');
        Route::post('/atividades/matricular/{id}', [AlunoController::class, 'matricular'])->name('atividades.matricular');
        Route::delete('/atividades/desmatricular/{id}', [AlunoController::class, 'desmatricular'])->name('atividades.desmatricular');
        Route::get('/perfil', [AlunoController::class, 'perfilEdit'])->name('perfil.edit');
        Route::post('/perfil', [AlunoController::class, 'perfilUpdate'])->name('perfil.update');
    });

    // Rotas de Atividades para Professores
    Route::prefix('professor')->name('professor.')->middleware('can:isProfessor')->group(function () {
        Route::get('/atividades', [ProfessoresController::class, 'profAtividadesIndex'])->name('atividades.index');
        Route::get('/atividades/minhas', [ProfessoresController::class, 'minhasAtividades'])->name('atividades.minhas');
        Route::get('/perfil', [ProfessoresController::class, 'perfilEdit'])->name('perfil.edit');
        Route::post('/perfil', [ProfessoresController::class, 'perfilUpdate'])->name('perfil.update');
    });

    // Rotas de Matrículas
    Route::prefix('matriculas')->name('matricula.')->group(function () {
        Route::get('/', [MatriculaController::class, 'index'])->name('index');
        Route::get('/geral', [MatriculaController::class, 'matriculageral'])->name('geral');
        Route::get('/aluno', [MatriculaController::class, 'matriculaaluno'])->name('aluno');
        Route::get('/confirmar/{id}', [MatriculaController::class, 'confirmar'])->name('confirmar');
        Route::get('/adicionar', [MatriculaController::class, 'adicionar'])->name('adicionar');
        Route::post('/matricular/{id}', [MatriculaController::class, 'matricular'])->name('matricular');
        Route::post('/salvar', [MatriculaController::class, 'salvar'])->name('salvar');
        Route::get('/editar/{id}', [MatriculaController::class, 'editar'])->name('editar');
        Route::get('/editaraluno/{id}', [MatriculaController::class, 'editaraluno'])->name('editaraluno');
        Route::post('/atualizar/{id}', [MatriculaController::class, 'atualizar'])->name('atualizar');
        Route::post('/atualizaraluno/{id}', [MatriculaController::class, 'atualizaraluno'])->name('atualizaraluno');
        Route::delete('/deletar/{id}', [MatriculaController::class, 'deletar'])->name('deletar');
    });

    // Rotas de Tipos
    Route::prefix('tipos')->name('tipo.')->group(function () {
        Route::get('/', [TiposController::class, 'index'])->name('index');
        Route::get('/adicionar', [TiposController::class, 'adicionar'])->name('adicionar');
        Route::post('/salvar', [TiposController::class, 'salvar'])->name('salvar');
        Route::get('/editar/{id}', [TiposController::class, 'editar'])->name('editar');
        Route::post('/atualizar/{id}', [TiposController::class, 'atualizar'])->name('atualizar');
        Route::delete('/deletar/{id}', [TiposController::class, 'deletar'])->name('deletar');
    });

    // Perfil
    Route::get('/perfil', [AdminController::class, 'perfilEdit'])->name('perfil.edit');
    Route::post('/perfil', [AdminController::class, 'perfilUpdate'])->name('perfil.update');
});
