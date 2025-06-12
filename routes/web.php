<?php

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\AtividadesController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AutenticacaoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\PainelAdmController;
use App\Http\Controllers\PpainelAdmController;
use App\Http\Controllers\ProfessoresController;
use App\Http\Controllers\TestMailController;
use App\Http\Controllers\TiposController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rotas de Redefinição de Senha
Route::middleware(['guest'])->group(function () {
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Rotas de Login e Registro
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AutenticacaoController::class, 'login'])->name('login');
    Route::post('/login', [AutenticacaoController::class, 'logindo'])->name('logindo');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login')->with('success', 'Você foi deslogado');
    })->name('logout');

    // Rotas para painéis de diferentes tipos de usuários
    Route::get('/paineladm', [PainelAdmController::class, 'index'])->name('paineladm');
    Route::get('/painelprof', [ProfessoresController::class, 'index'])->name('painelprof');
    Route::get('/painelaluno', [AlunoController::class, 'index'])->name('painelaluno');
});

// Rotas gerais para atividades, acessíveis a todos
Route::get('/atividades', [AtividadesController::class, 'listarAtividadesPublicas'])->name('atividades.listarPublicas');
Route::get('/atividades/{id}/horarios', [AtividadesController::class, 'buscarHorarios'])->name('atividades.horarios');
Route::get('/atividades/{id}', [AtividadesController::class, 'buscarAtividade'])->name('atividades.buscar');

// Rotas para administradores
Route::prefix('admin')->name('admin.')->middleware('can:isAdmin')->group(function () {
    Route::get('/painel', [PainelAdmController::class, 'index'])->name('painel');
    Route::get('/perfil/{id}/edit', [PainelAdmController::class, 'perfilEdit'])->name('perfil.edit');
    Route::put('/perfil/{id}', [PainelAdmController::class, 'perfilUpdate'])->name('perfil.update');
    Route::get('/perfil', [PainelAdmController::class, 'perfilIndex'])->name('perfil.index');

    // Rotas para atividades administradas pelo admin
    Route::prefix('atividades')->name('atividades.')->group(function () {
        Route::get('/', [AtividadesController::class, 'listarAtividades'])->name('index');
        Route::get('/adicionar', [AtividadesController::class, 'adicionarAtividade'])->name('create');
        Route::post('/store', [AtividadesController::class, 'salvarAtividade'])->name('store');
        Route::get('/{id}/editar', [AtividadesController::class, 'editarAtividade'])->name('edit');
        Route::delete('/{id}', [AtividadesController::class, 'deletarAtividade'])->name('destroy');
        Route::put('/{id}', [AtividadesController::class, 'update'])->name('update');
    });
});

// **Movido para fora do grupo "admin"**
// Rotas para Alunos
Route::prefix('aluno')->name('aluno.')->middleware('can:isAluno')->group(function () {
    Route::get('/painel', [AlunoController::class, 'index'])->name('painel');
    Route::get('/atividades', [AtividadesController::class, 'listarAtividadesAlunos'])->name('atividades.listarAluno');
    Route::get('/atividades/matriculadas', [MatriculaController::class, 'matriculaaluno'])->name('atividades.matriculadas');
    Route::post('/atividades/matricular/{id}', [MatriculaController::class, 'matricular'])->name('atividades.matricular');
    Route::delete('/atividades/desmatricular/{id}', [MatriculaController::class, 'desmatricular'])->name('atividades.desmatricular');
    Route::get('/perfil', [AlunoController::class, 'showPerfil'])->name('perfil.index');
    Route::get('/perfil/edit', [AlunoController::class, 'editPerfil'])->name('perfil.edit');
    Route::put('/perfil', [AlunoController::class, 'updatePerfil'])->name('perfil.update');
});

// Rotas para Professores
Route::prefix('professor')->name('professor.')->middleware('can:isProfessor')->group(function () {
    Route::get('/painel', [ProfessoresController::class, 'index'])->name('painel');
    Route::get('/atividades', [AtividadesController::class, 'listarParaProfessores'])->name('atividades.listarProfessor');
    Route::get('/atividades/matriculadas', [ProfessoresController::class, 'profAtividadesMatriculadas'])->name('atividades.matriculadas');
    Route::get('/atividades/{id}/horarios', [AtividadesController::class, 'buscarHorarios'])->name('atividades.horarios');
    Route::get('/atividades/{id}', [AtividadesController::class, 'buscarAtividade'])->name('atividades.buscar');
    Route::get('/perfil', [ProfessoresController::class, 'showPerfil'])->name('perfil.index');
    Route::get('/perfil/edit', [ProfessoresController::class, 'PerfilEdit'])->name('perfil.edit');
    Route::put('/perfil', [ProfessoresController::class, 'perfilUpdate'])->name('perfil.update');
});

// Rotas de Matrículas
Route::prefix('matriculas')->name('matricula.')->middleware('can:isAdmin')->group(function () {
    Route::get('/', [MatriculaController::class, 'index'])->name('index');
    Route::get('/geral', [MatriculaController::class, 'matriculageral'])->name('geral');
    Route::get('/confirmar/{id}', [MatriculaController::class, 'confirmar'])->name('confirmar');
    Route::get('/adicionar', [MatriculaController::class, 'adicionar'])->name('adicionar');
    Route::post('/salvar', [MatriculaController::class, 'salvar'])->name('salvar');
    Route::get('/editar/{id}', [MatriculaController::class, 'editar'])->name('editar');
    Route::put('/atualizar/{id}', [MatriculaController::class, 'atualizar'])->name('atualizar');
    Route::delete('/deletar/{id}', [MatriculaController::class, 'deletar'])->name('deletar');
});

// Rotas de Tipos (Admin)
Route::prefix('tipos')->name('tipo.')->middleware('can:isAdmin')->group(function () {
    Route::get('/', [TiposController::class, 'index'])->name('index');
    Route::get('/adicionar', [TiposController::class, 'adicionar'])->name('adicionar');
    Route::post('/salvar', [TiposController::class, 'salvar'])->name('salvar');
    Route::get('/{id}/editar', [TiposController::class, 'editar'])->name('editar');
    Route::put('/{id}', [TiposController::class, 'atualizar'])->name('atualizar');
    Route::delete('/{id}', [TiposController::class, 'deletar'])->name('deletar');
});

// Rota de Teste para envio de email
Route::get('/send-test-email', [TestMailController::class, 'sendTestEmail'])->name('send-test-email');

// Rotas de Usuários
Route::prefix('usuarios')->name('usuarios.')->group(function () {
    Route::get('/', [UsuariosController::class, 'index'])->name('index'); // Listar usuários
    Route::get('/adicionar', [UsuariosController::class, 'adicionar'])->name('create'); // Exibir formulário para adicionar novo usuário
    Route::post('/store', [UsuariosController::class, 'salvar'])->name('store'); // Salvar novo usuário
    Route::get('/{id}/editar', [UsuariosController::class, 'editar'])->name('edit'); // Exibir formulário para editar usuário existente
    Route::put('/{id}/atualizar', [UsuariosController::class, 'atualizar'])->name('update'); // Atualizar usuário existente
    Route::delete('/{id}', [UsuariosController::class, 'deletar'])->name('destroy'); // Deletar usuário
});

//  ROTA TEMPORÁRIA, APAGUE DEPOIS!
Route::get('/run-migrate', function() {
    \Artisan::call('migrate --force');
    \Artisan::call('db:seed --force');
    return 'Migrations e seeders rodados!';
});