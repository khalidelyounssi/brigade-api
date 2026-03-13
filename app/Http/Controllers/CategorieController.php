<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::where('user_id', auth()->id())->get();

        return response()->json($categories, 200);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Categorie::class);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $categorie = Categorie::create([
            'name' => $data['name'],
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Catégorie créée avec succès',
            'categorie' => $categorie,
        ], 201);
    }

    public function show(Categorie $categorie)
    {
        $this->authorize('view', $categorie);

        return response()->json($categorie, 200);
    }

    public function update(Request $request, Categorie $categorie)
    {
        $this->authorize('update', $categorie);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $categorie->update($data);

        return response()->json([
            'message' => 'Catégorie mise à jour avec succès',
            'categorie' => $categorie,
        ], 200);
    }

    public function destroy(Categorie $categorie)
    {
        $this->authorize('delete', $categorie);

        $categorie->delete();

        return response()->json([
            'message' => 'Catégorie supprimée avec succès',
        ], 200);
    }
}