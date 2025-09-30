<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $activeGoals = $user->goals()->active()->orderBy('target_date')->get();
        $completedGoals = $user->goals()->completed()->orderBy('updated_at', 'desc')->limit(5)->get();

        return view('goals.index', compact('activeGoals', 'completedGoals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('goals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'target_amount' => 'required|numeric|min:0.01',
                'target_date' => 'required|date|after:today',
                'type' => 'required|in:savings,expense_reduction,income_increase',
                'current_amount' => 'nullable|numeric|min:0'
            ]);

            $goal = Auth::user()->goals()->create([
                'name' => $request->name,
                'description' => $request->description,
                'target_amount' => $request->target_amount,
                'current_amount' => $request->current_amount ?? 0,
                'target_date' => $request->target_date,
                'type' => $request->type,
                'status' => 'active'
            ]);

            // Se for uma requisição AJAX, retornar JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Meta criada com sucesso!',
                    'goal' => $goal
                ]);
            }

            return redirect()->route('goals.index')
                            ->with('success', 'Meta criada com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro interno do servidor'
                ], 500);
            }
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Goal $goal)
    {
        // Verificar se a meta pertence ao usuário
        if ($goal->user_id !== Auth::id()) {
            abort(403);
        }

        return view('goals.show', compact('goal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Goal $goal)
    {
        // Verificar se a meta pertence ao usuário
        if ($goal->user_id !== Auth::id()) {
            abort(403);
        }

        return view('goals.edit', compact('goal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Goal $goal)
    {
        // Verificar se a meta pertence ao usuário
        if ($goal->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|numeric|min:0.01',
            'target_date' => 'required|date',
            'type' => 'required|in:savings,expense_reduction,income_increase',
            'current_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,completed,paused'
        ]);

        $goal->update([
            'name' => $request->name,
            'description' => $request->description,
            'target_amount' => $request->target_amount,
            'current_amount' => $request->current_amount ?? $goal->current_amount,
            'target_date' => $request->target_date,
            'type' => $request->type,
            'status' => $request->status
        ]);

        $goal->updateProgress();

        return redirect()->route('goals.index')
                        ->with('success', 'Meta atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goal $goal)
    {
        // Verificar se a meta pertence ao usuário
        if ($goal->user_id !== Auth::id()) {
            abort(403);
        }

        $goal->delete();

        return redirect()->route('goals.index')
                        ->with('success', 'Meta excluída com sucesso!');
    }

    /**
     * Update progress of a goal
     */
    public function updateProgress(Request $request, Goal $goal)
    {
        // Verificar se a meta pertence ao usuário
        if ($goal->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0'
        ]);

        $goal->update([
            'current_amount' => $request->amount
        ]);

        $goal->updateProgress();

        return redirect()->back()
                        ->with('success', 'Progresso atualizado com sucesso!');
    }
}
