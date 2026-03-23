<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategorieController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Categorie::query();

        if ($request->has('active')) {
            $active = filter_var($request->query('active'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if (!is_null($active)) {
                $query->where('is_active', $active);
            }
        }

        $categories = $query->get();

        return response()->json($categories, 200);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Accès interdit',
            ], 403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
            'color' => ['nullable', 'regex:/^#([A-Fa-f0-9]{6})$/'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $categorie = Categorie::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'color' => $data['color'] ?? null,
            'is_active' => $data['is_active'] ?? true,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Catégorie créée avec succès',
            'categorie' => $categorie,
        ], 201);
    }

    public function show(Categorie $categorie)
    {
        return response()->json($categorie, 200);
    }

    public function update(Request $request, Categorie $categorie)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Accès interdit',
            ], 403);
        }

        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:100', 'unique:categories,name,' . $categorie->id],
            'description' => ['sometimes', 'nullable', 'string'],
            'color' => ['sometimes', 'nullable', 'regex:/^#([A-Fa-f0-9]{6})$/'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $categorie->update($data);

        return response()->json([
            'message' => 'Catégorie mise à jour avec succès',
            'categorie' => $categorie,
        ], 200);
    }

    public function destroy(Categorie $categorie)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Accès interdit',
            ], 403);
        }

        $hasActivePlats = $categorie->plats()->where('is_available', true)->exists();

        if ($hasActivePlats) {
            return response()->json([
                'message' => 'Impossible de supprimer une catégorie qui contient des plats actifs',
            ], 422);
        }

        $categorie->delete();

        return response()->json([
            'message' => 'Catégorie supprimée avec succès',
        ], 200);
    }

    public function plates(Categorie $categorie)
    {
        $plats = $categorie->plats()
            ->where('is_available', true)
            ->with('recommendations')
            ->get()
            ->map(function ($plat) {
                $recommendation = $plat->recommendations()
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->first();

                return [
                    'id' => $plat->id,
                    'name' => $plat->name,
                    'description' => $plat->description,
                    'price' => $plat->price,
                    'image' => $plat->image,
                    'is_available' => $plat->is_available,
                    'category_id' => $plat->category_id,
                    'recommendation' => $recommendation ? [
                        'score' => $recommendation->score,
                        'label' => $recommendation->label,
                        'status' => $recommendation->status,
                    ] : [
                        'status' => 'processing'
                    ],
                ];
            });

        return response()->json($plats, 200);
    }
}