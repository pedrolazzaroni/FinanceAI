<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Dados dos últimos 6 meses
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $income = $user->transactions()
                ->income()
                ->whereMonth('transaction_date', $month->month)
                ->whereYear('transaction_date', $month->year)
                ->sum('amount');
            $expenses = $user->transactions()
                ->expense()
                ->whereMonth('transaction_date', $month->month)
                ->whereYear('transaction_date', $month->year)
                ->sum('amount');

            $monthlyData[] = [
                'month' => $month->format('M/Y'),
                'income' => $income,
                'expenses' => $expenses,
                'balance' => $income - $expenses
            ];
        }

        // Gastos por categoria (últimos 3 meses)
        $categoryExpenses = $user->transactions()
            ->expense()
            ->where('transaction_date', '>=', Carbon::now()->subMonths(3))
            ->with('category')
            ->selectRaw('category_id, sum(amount) as total')
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->get();

        return view('reports.index', compact('monthlyData', 'categoryExpenses'));
    }

    public function generate(Request $request)
    {
        $user = Auth::user();

        // Coletar dados financeiros do usuário
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        $currentMonthIncome = $user->transactions()
            ->income()
            ->whereMonth('transaction_date', $currentMonth->month)
            ->whereYear('transaction_date', $currentMonth->year)
            ->sum('amount');

        $currentMonthExpenses = $user->transactions()
            ->expense()
            ->whereMonth('transaction_date', $currentMonth->month)
            ->whereYear('transaction_date', $currentMonth->year)
            ->sum('amount');

        $lastMonthIncome = $user->transactions()
            ->income()
            ->whereMonth('transaction_date', $lastMonth->month)
            ->whereYear('transaction_date', $lastMonth->year)
            ->sum('amount');

        $lastMonthExpenses = $user->transactions()
            ->expense()
            ->whereMonth('transaction_date', $lastMonth->month)
            ->whereYear('transaction_date', $lastMonth->year)
            ->sum('amount');

        // Gastos por categoria no mês atual
        $categoryExpenses = $user->transactions()
            ->expense()
            ->whereMonth('transaction_date', $currentMonth->month)
            ->whereYear('transaction_date', $currentMonth->year)
            ->with('category')
            ->selectRaw('category_id, sum(amount) as total')
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->get();

        // Gerar análise com IA simulada
        $analysis = $this->generateFinancialAnalysis([
            'current_income' => $currentMonthIncome,
            'current_expenses' => $currentMonthExpenses,
            'last_income' => $lastMonthIncome,
            'last_expenses' => $lastMonthExpenses,
            'category_expenses' => $categoryExpenses,
            'balance' => $currentMonthIncome - $currentMonthExpenses
        ]);

        return view('reports.analysis', compact('analysis'));
    }

    private function generateFinancialAnalysis($data)
    {
        $analysis = [
            'overall_health' => '',
            'recommendations' => [],
            'warnings' => [],
            'positive_points' => [],
            'spending_insights' => []
        ];

        // Análise do saldo atual
        if ($data['balance'] > 0) {
            $analysis['overall_health'] = 'Boa';
            $analysis['positive_points'][] = "Parabéns! Você teve um saldo positivo de R$ " . number_format($data['balance'], 2, ',', '.') . " neste mês.";
        } elseif ($data['balance'] == 0) {
            $analysis['overall_health'] = 'Neutra';
            $analysis['warnings'][] = "Você gastou exatamente o que ganhou este mês. Cuidado para não entrar no vermelho.";
        } else {
            $analysis['overall_health'] = 'Atenção';
            $analysis['warnings'][] = "Você gastou R$ " . number_format(abs($data['balance']), 2, ',', '.') . " a mais do que ganhou este mês.";
        }

        // Comparação com mês anterior
        $incomeVariation = $data['current_income'] - $data['last_income'];
        $expenseVariation = $data['current_expenses'] - $data['last_expenses'];

        if ($incomeVariation > 0) {
            $analysis['positive_points'][] = "Sua renda aumentou R$ " . number_format($incomeVariation, 2, ',', '.') . " em relação ao mês passado.";
        } elseif ($incomeVariation < 0) {
            $analysis['warnings'][] = "Sua renda diminuiu R$ " . number_format(abs($incomeVariation), 2, ',', '.') . " em relação ao mês passado.";
        }

        if ($expenseVariation > 0) {
            $analysis['warnings'][] = "Seus gastos aumentaram R$ " . number_format($expenseVariation, 2, ',', '.') . " em relação ao mês passado.";
        } elseif ($expenseVariation < 0) {
            $analysis['positive_points'][] = "Você economizou R$ " . number_format(abs($expenseVariation), 2, ',', '.') . " em gastos em relação ao mês passado.";
        }

        // Análise por categoria
        $topCategory = $data['category_expenses']->first();
        if ($topCategory) {
            $analysis['spending_insights'][] = "Sua maior categoria de gastos é '{$topCategory->category->name}' com R$ " . number_format($topCategory->total, 2, ',', '.');

            // Percentual dos gastos
            $percentage = ($topCategory->total / $data['current_expenses']) * 100;
            if ($percentage > 40) {
                $analysis['recommendations'][] = sprintf(
                    "A categoria '%s' representa %.1f%% dos seus gastos. Considere revisar estes gastos.",
                    $topCategory->category->name,
                    $percentage
                );
            }
        }

        // Recomendações gerais
        if ($data['current_expenses'] > $data['current_income'] * 0.9) {
            $analysis['recommendations'][] = "Você está gastando mais de 90% da sua renda. Considere criar uma reserva de emergência.";
        }

        if ($data['balance'] > 0) {
            $analysis['recommendations'][] = "Considere investir parte do seu saldo positivo para fazer seu dinheiro render.";
        }

        $analysis['recommendations'][] = "Mantenha o controle regular dos seus gastos para melhores resultados financeiros.";

        return $analysis;
    }
}
