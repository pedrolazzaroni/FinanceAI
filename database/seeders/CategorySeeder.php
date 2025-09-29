<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expenseCategories = [
            ['name' => 'Alimentação', 'type' => 'expense', 'color' => '#e74c3c', 'icon' => '🍽️'],
            ['name' => 'Transporte', 'type' => 'expense', 'color' => '#3498db', 'icon' => '🚗'],
            ['name' => 'Moradia', 'type' => 'expense', 'color' => '#9b59b6', 'icon' => '🏠'],
            ['name' => 'Saúde', 'type' => 'expense', 'color' => '#2ecc71', 'icon' => '⚕️'],
            ['name' => 'Educação', 'type' => 'expense', 'color' => '#f39c12', 'icon' => '📚'],
            ['name' => 'Lazer', 'type' => 'expense', 'color' => '#e67e22', 'icon' => '🎮'],
            ['name' => 'Roupas', 'type' => 'expense', 'color' => '#1abc9c', 'icon' => '👕'],
            ['name' => 'Outros Gastos', 'type' => 'expense', 'color' => '#95a5a6', 'icon' => '💸'],
        ];

        $incomeCategories = [
            ['name' => 'Salário', 'type' => 'income', 'color' => '#27ae60', 'icon' => '💰'],
            ['name' => 'Freelance', 'type' => 'income', 'color' => '#16a085', 'icon' => '💻'],
            ['name' => 'Investimentos', 'type' => 'income', 'color' => '#2980b9', 'icon' => '📈'],
            ['name' => 'Vendas', 'type' => 'income', 'color' => '#8e44ad', 'icon' => '🛒'],
            ['name' => 'Outras Receitas', 'type' => 'income', 'color' => '#f1c40f', 'icon' => '💎'],
        ];

        foreach ($expenseCategories as $category) {
            Category::create($category);
        }

        foreach ($incomeCategories as $category) {
            Category::create($category);
        }
    }
}
