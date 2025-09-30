<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentMonth = Carbon::now();
        
        // Totais do mês atual
        $monthlyIncome = $user->transactions()
            ->income()
            ->currentMonth()
            ->sum('amount');
            
        $monthlyExpenses = $user->transactions()
            ->expense()
            ->currentMonth()
            ->sum('amount');
            
        $monthlyBalance = $monthlyIncome - $monthlyExpenses;
        
        // Transações recentes (últimas 10)
        $recentTransactions = $user->transactions()
            ->with('category')
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // Gastos por categoria no mês atual
        $expensesByCategory = $user->transactions()
            ->expense()
            ->currentMonth()
            ->with('category')
            ->selectRaw('category_id, sum(amount) as total')
            ->groupBy('category_id')
            ->get();
            
        // Categorias
        $incomeCategories = Category::income()->get();
        $expenseCategories = Category::expense()->get();
        
        // Metas ativas
        $activeGoals = $user->goals()
            ->active()
            ->orderBy('target_date')
            ->limit(3)
            ->get();
        
        return view('dashboard', compact(
            'monthlyIncome',
            'monthlyExpenses', 
            'monthlyBalance',
            'recentTransactions',
            'expensesByCategory',
            'incomeCategories',
            'expenseCategories',
            'activeGoals'
        ));
    }
}
