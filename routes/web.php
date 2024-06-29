<?php

use App\Http\Controllers\PainelAdmController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacaoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\AtividadesController;
use App\Http\Controllers\Auth\LoginController;
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
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

  // Rotas de Usuários para Administradores
Route::prefix('usuarios')->name('usuarios.')->middleware('can:isAdmin')->group(function () {
    Route::get('/', [PainelAdmController::class, 'listarUsuarios'])->name('listar');
    Route::get('/adicionar', [PainelAdmController::class, 'adicionar'])->name('adicionar');
    Route::post('/store', [PainelAdmController::class, 'salvar'])->name('store');
    Route::get('/{id}/editar', [PainelAdmController::class, 'editar'])->name('editar');
    Route::post('/{id}/atualizar', [PainelAdmController::class, 'atualizar'])->name('update');
    Route::delete('/{id}', [PainelAdmController::class, 'deletar'])->name('destroy');
});


    // Rotas para painéis
    Route::get('/paineladm', [PainelAdmController::class, 'index'])->name('paineladm');
    Route::get('/painelprof', [ProfessoresController::class, 'index'])->name('painelprof');
    Route::get('/painelaluno', [AlunoController::class, 'index'])->name('painelaluno');

  // Rotas de Administradores
Route::prefix('admin')->name('admin.')->middleware('can:isAdmin')->group(function () {
    Route::get('/painel', [PainelAdmController::class, 'index'])->name('painel');

    // Rotas de Usuários
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [PainelAdmController::class, 'listarUsuarios'])->name('index');
        Route::get('/adicionar', [PainelAdmController::class, 'adicionarUsuario'])->name('create');
        Route::post('/store', [PainelAdmController::class, 'salvarUsuario'])->name('store');
        Route::get('/{id}/editar', [PainelAdmController::class, 'editarUsuario'])->name('edit');
        Route::post('/{id}/atualizar', [PainelAdmController::class, 'atualizarUsuario'])->name('update');
        Route::delete('/{id}', [PainelAdmController::class, 'deletarUsuario'])->name('destroy');
    });
});
// Rotas de Atividades para Administradores
Route::prefix('atividades')->name('atividades.')->middleware('can:isAdmin')->group(function () {
    Route::get('/', [AtividadesController::class, 'index'])->name('index');
    Route::get('/listar', [AtividadesController::class, 'listarAtividades'])->name('listar');
    Route::get('/adicionar', [AtividadesController::class, 'adicionarAtividade'])->name('create');
    Route::post('/store', [AtividadesController::class, 'salvarAtividade'])->name('store');
    Route::get('/{id}/editar', [AtividadesController::class, 'editarAtividade'])->name('editar');
    Route::put('/{id}', [AtividadesController::class, 'atualizarAtividade'])->name('update');
    Route::delete('/{id}', [AtividadesController::class, 'deletarAtividade'])->name('destroy');
});



// Rotas de Atividades para Alunos
Route::prefix('aluno')->name('aluno.')->middleware('auth')->group(function () {
    Route::get('/painelaluno', [AlunoController::class, 'index'])->name('painel');
    Route::get('/atividades', [AtividadesController::class, 'listar'])->name('atividades.listar');
    Route::get('/atividades/matriculadas', [AlunoController::class, 'atividadesMatriculadas'])->name('atividades.matriculadas');
    Route::post('/atividades/matricular/{id}', [MatriculaController::class, 'matricular'])->name('atividades.matricular');
    Route::delete('/atividades/desmatricular/{id}', [AlunoController::class, 'desmatricular'])->name('atividades.desmatricular');
    Route::get('/perfil', [AlunoController::class, 'perfilEdit'])->name('perfil.edit');
    Route::post('/perfil', [AlunoController::class, 'perfilUpdate'])->name('perfil.update');
});



// Rotas de Matrículas
Route::prefix('matriculas')->name('matricula.')->middleware('auth')->group(function () {
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





// Rotas de Atividades para Professores
Route::prefix('professor')->name('professor.')->middleware('can:isProfessor')->group(function () {
    Route::get('/atividades', [ProfessoresController::class, 'profAtividadesIndex'])->name('atividades.listar');
    Route::get('/atividades/minhas', [ProfessoresController::class, 'minhasAtividades'])->name('atividades.minhas');
    Route::get('/perfil', [ProfessoresController::class, 'perfilEdit'])->name('perfil.edit');
    Route::post('/perfil', [ProfessoresController::class, 'perfilUpdate'])->name('perfil.update');
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
    Route::get('/perfil', [PainelAdmController::class, 'perfilEdit'])->name('perfil.edit');
    Route::post('/perfil', [PainelAdmController::class, 'perfilUpdate'])->name('perfil.update');
});

Route::middleware('auth')->group(function () {
    Route::prefix('usuario')->name('usuario.')->group(function () {
        Route::get('/', [UsuariosController::class, 'index'])->name('index');
        Route::get('/adicionar', [UsuariosController::class, 'adicionar'])->name('adicionar');
        Route::post('/salvar', [UsuariosController::class, 'salvar'])->name('salvar');
        Route::get('/editar/{id}', [UsuariosController::class, 'editar'])->name('editar');
        Route::post('/atualizar/{id}', [UsuariosController::class, 'atualizar'])->name('atualizar');
        Route::delete('/deletar/{id}', [UsuariosController::class, 'deletar'])->name('deletar');
    });
});



