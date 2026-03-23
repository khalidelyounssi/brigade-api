<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        return response()->json(Ingredient::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'tags' => 'nullable|array'
        ]);

        $ingredient = Ingredient::create($data);

        return response()->json($ingredient, 201);
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'tags' => 'sometimes|array'
        ]);

        $ingredient->update($data);

        return response()->json($ingredient);
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();

        return response()->json([
            'message' => 'Ingredient deleted'
        ]);
    }
}