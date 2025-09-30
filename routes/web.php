<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\AiAnalysisController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/painel', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rotas para transações
    Route::get('/transacoes', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transacoes/criar', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transacoes', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transacoes/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transacoes/{transaction}/editar', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transacoes/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transacoes/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    
    // Rotas para relatórios
    Route::get('/relatorios', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/relatorios/gerar', [ReportController::class, 'generate'])->name('reports.generate');
    Route::get('/relatorios/analise', [ReportController::class, 'analysis'])->name('reports.analysis');
    
    // Rotas para metas
    Route::get('/metas', [GoalController::class, 'index'])->name('goals.index');
    Route::get('/metas/criar', [GoalController::class, 'create'])->name('goals.create');
    Route::post('/metas', [GoalController::class, 'store'])->name('goals.store');
    Route::get('/metas/{goal}', [GoalController::class, 'show'])->name('goals.show');
    Route::get('/metas/{goal}/editar', [GoalController::class, 'edit'])->name('goals.edit');
    Route::put('/metas/{goal}', [GoalController::class, 'update'])->name('goals.update');
    Route::delete('/metas/{goal}', [GoalController::class, 'destroy'])->name('goals.destroy');
    Route::patch('/metas/{goal}/progresso', [GoalController::class, 'updateProgress'])->name('goals.update-progress');
    
    // Rotas para análise IA
    Route::post('/analise-ia', [AiAnalysisController::class, 'generateAnalysis'])->name('ai.analysis');
});

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
