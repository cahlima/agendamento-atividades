<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PainelAdmController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacaoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\AtividadesController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TiposController; // Certifique-se de importar o controlador de tipos

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rotas de Autenticação
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AutenticacaoController::class, 'login'])->name('login');
    Route::post('/login', [AutenticacaoController::class, 'logindo'])->name('logindo');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AutenticacaoController::class, 'logout'])->name('logout');

    // Rotas para painéis
    Route::get('/paineladm', [PainelAdmController::class, 'index'])->name('paineladm');
    Route::view('/paineladm', 'administrador.paineladm')->name('paineladm');
    Route::view('/painelprof', 'professor.painelprof')->name('painelprof');
    Route::view('/painelaluno', 'aluno.painelaluno')->name('painelaluno');

    // Rota para home (genérico)
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Rotas de Atividades
    Route::resource('atividades', AtividadesController::class);
    Route::get('/admin/atividades/create', [AdminController::class, 'create'])->name('admin.atividades.create');

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

    // Rotas de Usuários
    Route::prefix('usuarios')->name('usuario.')->group(function () {
        Route::get('/', [UsuarioController::class, 'index'])->name('index');
        Route::get('/adicionar', [UsuarioController::class, 'adicionar'])->name('adicionar');
        Route::post('/salvar', [UsuarioController::class, 'salvar'])->name('salvar');
        Route::get('/editar/{id}', [UsuarioController::class, 'editar'])->name('editar');
        Route::post('/atualizar/{id}', [UsuarioController::class, 'atualizar'])->name('atualizar');
        Route::delete('/deletar/{id}', [UsuarioController::class, 'deletar'])->name('deletar');
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
});
