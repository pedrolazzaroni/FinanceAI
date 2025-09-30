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

        // Gerar análise com IA do Gemini
        $analysis = $this->generateGeminiAnalysis([
            'current_income' => $currentMonthIncome,
            'current_expenses' => $currentMonthExpenses,
            'last_income' => $lastMonthIncome,
            'last_expenses' => $lastMonthExpenses,
            'category_expenses' => $categoryExpenses,
            'balance' => $currentMonthIncome - $currentMonthExpenses
        ]);

        return view('reports.analysis', compact('analysis'));
    }

    private function generateGeminiAnalysis($data)
    {
        $apiKey = env('GEMINI_API_KEY');
        
        if (!$apiKey) {
            return $this->generateFinancialAnalysis($data);
        }

        // Preparar dados para o prompt
        $categoryData = $data['category_expenses']->map(function($item) {
            return [
                'categoria' => $item->category->name,
                'valor' => $item->total
            ];
        })->toArray();

        $prompt = "Analise esta situação financeira e forneça uma análise detalhada em português brasileiro:

Dados Financeiros:
- Receita atual: R$ " . number_format($data['current_income'], 2, ',', '.') . "
- Gastos atuais: R$ " . number_format($data['current_expenses'], 2, ',', '.') . "
- Saldo atual: R$ " . number_format($data['balance'], 2, ',', '.') . "
- Receita mês anterior: R$ " . number_format($data['last_income'], 2, ',', '.') . "
- Gastos mês anterior: R$ " . number_format($data['last_expenses'], 2, ',', '.') . "

Gastos por categoria:
" . collect($categoryData)->map(function($cat) {
    return "- {$cat['categoria']}: R$ " . number_format($cat['valor'], 2, ',', '.');
})->implode("\n") . "

Forneça uma análise estruturada com:
1. Situação geral (boa/regular/preocupante)
2. Pontos positivos (máximo 3)
3. Alertas e preocupações (máximo 3)
4. Recomendações práticas (máximo 4)
5. Insights sobre gastos por categoria (máximo 2)

Seja direto, prático e use linguagem acessível. Foque em conselhos acionáveis.";

        try {
            $response = $this->callGeminiAPI($prompt, $apiKey);
            return $this->parseGeminiResponse($response);
        } catch (\Exception $e) {
            \Log::error('Erro ao gerar análise com Gemini: ' . $e->getMessage());
            return $this->generateFinancialAnalysis($data);
        }
    }

    private function callGeminiAPI($prompt, $apiKey)
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key=" . $apiKey;
        
        $data = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $prompt
                        ]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 1,
                'topP' => 1,
                'maxOutputTokens' => 2048,
            ]
        ];

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => [
                    'Content-Type: application/json',
                ],
                'content' => json_encode($data),
                'timeout' => 30
            ]
        ]);

        $response = file_get_contents($url, false, $context);
        
        if ($response === false) {
            throw new \Exception('Falha na requisição para Gemini API');
        }

        return json_decode($response, true);
    }

    private function parseGeminiResponse($response)
    {
        if (!isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            throw new \Exception('Resposta inválida da API Gemini');
        }

        $text = $response['candidates'][0]['content']['parts'][0]['text'];
        
        // Estrutura básica de retorno
        $analysis = [
            'overall_health' => 'Regular',
            'recommendations' => [],
            'warnings' => [],
            'positive_points' => [],
            'spending_insights' => [],
            'ai_analysis' => $text // Texto completo da IA
        ];

        // Parse básico do texto para extrair seções
        $lines = explode("\n", $text);
        $currentSection = '';
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            // Identificar seções
            if (stripos($line, 'situação') !== false || stripos($line, 'geral') !== false) {
                if (stripos($line, 'boa') !== false) $analysis['overall_health'] = 'Boa';
                elseif (stripos($line, 'preocupante') !== false) $analysis['overall_health'] = 'Atenção';
                continue;
            }
            
            // Extrair pontos positivos
            if (stripos($line, 'positiv') !== false || preg_match('/^\d+\.?\s*\+/', $line)) {
                $currentSection = 'positive';
                continue;
            }
            
            // Extrair alertas
            if (stripos($line, 'alert') !== false || stripos($line, 'preocup') !== false || preg_match('/^\d+\.?\s*⚠/', $line)) {
                $currentSection = 'warnings';
                continue;
            }
            
            // Extrair recomendações
            if (stripos($line, 'recomend') !== false || preg_match('/^\d+\.?\s*💡/', $line)) {
                $currentSection = 'recommendations';
                continue;
            }
            
            // Extrair insights
            if (stripos($line, 'insight') !== false || stripos($line, 'categoria') !== false) {
                $currentSection = 'insights';
                continue;
            }
            
            // Adicionar conteúdo à seção atual
            if ($currentSection && !empty($line) && !preg_match('/^\d+\.?\s*$/', $line)) {
                $cleanLine = preg_replace('/^[\d\.\-\*\+•]\s*/', '', $line);
                if (!empty($cleanLine)) {
                    switch ($currentSection) {
                        case 'positive':
                            if (count($analysis['positive_points']) < 3) {
                                $analysis['positive_points'][] = $cleanLine;
                            }
                            break;
                        case 'warnings':
                            if (count($analysis['warnings']) < 3) {
                                $analysis['warnings'][] = $cleanLine;
                            }
                            break;
                        case 'recommendations':
                            if (count($analysis['recommendations']) < 4) {
                                $analysis['recommendations'][] = $cleanLine;
                            }
                            break;
                        case 'insights':
                            if (count($analysis['spending_insights']) < 2) {
                                $analysis['spending_insights'][] = $cleanLine;
                            }
                            break;
                    }
                }
            }
        }

        return $analysis;
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
