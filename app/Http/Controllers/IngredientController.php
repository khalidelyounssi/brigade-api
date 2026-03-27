<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::withCount('plats')->latest()->get();

        return response()->json([
            'ingredients' => $ingredients,
        ], 200);
    }

    public function store(Request $request)
    {
        if (! auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Accès interdit',
            ], 403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:100',
        ]);

        $data['tags'] = $data['tags'] ?? [];
        $ingredient = Ingredient::create($data);

        return response()->json([
            'message' => 'Ingredient créé avec succès',
            'ingredient' => $ingredient,
        ], 201);
    }

    public function show(Ingredient $ingredient)
    {
        $ingredient->load('plats');

        return response()->json([
            'ingredient' => $ingredient,
        ], 200);
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        if (! auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Accès interdit',
            ], 403);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'tags' => 'sometimes|array',
            'tags.*' => 'string|max:100',
        ]);

        $ingredient->update($data);

        return response()->json([
            'message' => 'Ingredient mis à jour avec succès',
            'ingredient' => $ingredient,
        ], 200);
    }

    public function destroy(Ingredient $ingredient)
    {
        if (! auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Accès interdit',
            ], 403);
        }

        $ingredient->plats()->detach();
        $ingredient->delete();

        return response()->json([
            'message' => 'Ingredient deleted'
        ], 200);
    }
}
