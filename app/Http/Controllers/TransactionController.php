<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $user->transactions()->with('category');
        
        // Filtros
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }
        
        $transactions = $query->orderBy('transaction_date', 'desc')
                             ->orderBy('created_at', 'desc')
                             ->paginate(20);
        
        $categories = Category::all();
        
        return view('transactions.index', compact('transactions', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('transactions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $user = Auth::user();
        
        $user->transactions()->create([
            'type' => $request->type,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
            'notes' => $request->notes
        ]);

        return redirect()->route('transactions.index')
                        ->with('success', 'Transação adicionada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        // Verificar se a transação pertence ao usuário
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        // Verificar se a transação pertence ao usuário
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        
        $categories = Category::all();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Verificar se a transação pertence ao usuário
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $transaction->update([
            'type' => $request->type,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
            'notes' => $request->notes
        ]);

        return redirect()->route('transactions.index')
                        ->with('success', 'Transação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Verificar se a transação pertence ao usuário
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        
        $transaction->delete();

        return redirect()->route('transactions.index')
                        ->with('success', 'Transação excluída com sucesso!');
    }
}
