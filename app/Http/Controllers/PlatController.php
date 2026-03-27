<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use App\Models\Categorie;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;

class PlatController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $plats = Plat::with(['categorie', 'ingredients', 'recommendations'])
            ->where('is_available', true)
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
                    'category' => $plat->categorie,
                    'ingredients' => $plat->ingredients,
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

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Accès interdit',
            ], 403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],
            'is_available' => 'nullable|boolean',
            'ingredient_ids' => 'nullable|array',
            'ingredient_ids.*' => 'exists:ingredients,id',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $imageUrl = Cloudinary::upload(
                $request->file('image')->getRealPath()
            )->getSecurePath();

            $data['image'] = $imageUrl;
        }

        $data['user_id'] = auth()->id();
        $data['is_available'] = $data['is_available'] ?? true;

        $plat = Plat::create($data);

        if (!empty($data['ingredient_ids'])) {
            $plat->ingredients()->sync($data['ingredient_ids']);
        }

        return response()->json([
            'message' => 'Plat créé avec succès',
            'plat' => $plat->load(['categorie', 'ingredients']),
        ], 201);
    }

    public function show(Plat $plat)
    {
        if ((int) $plat->user_id !== (int) auth()->id()) {
            return response()->json([
                'message' => 'Accès interdit',
            ], 403);
        }

        $recommendation = $plat->recommendations()
            ->where('user_id', auth()->id())
            ->latest()
            ->first();

        return response()->json([
            'id' => $plat->id,
            'name' => $plat->name,
            'description' => $plat->description,
            'price' => $plat->price,
            'image' => $plat->image,
            'is_available' => $plat->is_available,
            'category' => $plat->categorie,
            'ingredients' => $plat->ingredients,
            'recommendation' => $recommendation ? [
                'score' => $recommendation->score,
                'label' => $recommendation->label,
                'warning_message' => $recommendation->warning_message,
                'status' => $recommendation->status,
            ] : [
                'status' => 'processing'
            ],
        ], 200);
    }

    public function update(Request $request, Plat $plat)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Accès interdit',
            ], 403);
        }
        if ((int) $plat->user_id !== (int) auth()->id()) {
            return response()->json([
                'message' => 'Accès interdit',
            ], 403);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:100',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'category_id' => [
                'sometimes',
                'integer',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],
            'is_available' => 'sometimes|boolean',
            'ingredient_ids' => 'sometimes|array',
            'ingredient_ids.*' => 'exists:ingredients,id',
            'image' => 'sometimes|nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $imageUrl = Cloudinary::upload(
                $request->file('image')->getRealPath()
            )->getSecurePath();

            $data['image'] = $imageUrl;
        }

        $plat->update($data);

        if (array_key_exists('ingredient_ids', $data)) {
            $plat->ingredients()->sync($data['ingredient_ids'] ?? []);
        }

        return response()->json([
            'message' => 'Plat mis à jour avec succès',
            'plat' => $plat->load(['categorie', 'ingredients']),
        ], 200);
    }

    public function destroy(Plat $plat)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Accès interdit',
            ], 403);
        }
        if ((int) $plat->user_id !== (int) auth()->id()) {
            return response()->json([
                'message' => 'Accès interdit',
            ], 403);
        }

        $plat->delete();

        return response()->json([
            'message' => 'Plat supprimé avec succès',
        ], 200);
    }

    public function storeByCategory(Request $request, Categorie $categorie)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Accès interdit',
            ], 403);
        }
        if ((int) $categorie->user_id !== (int) auth()->id()) {
            return response()->json([
                'message' => 'Accès interdit',
            ], 403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'nullable|boolean',
            'ingredient_ids' => 'nullable|array',
            'ingredient_ids.*' => 'exists:ingredients,id',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $imageUrl = Cloudinary::upload(
                $request->file('image')->getRealPath()
            )->getSecurePath();

            $data['image'] = $imageUrl;
        }

        $data['category_id'] = $categorie->id;
        $data['user_id'] = auth()->id();
        $data['is_available'] = $data['is_available'] ?? true;

        $plat = Plat::create($data);

        if (!empty($data['ingredient_ids'])) {
            $plat->ingredients()->sync($data['ingredient_ids']);
        }

        return response()->json([
            'message' => 'Plat ajouté à la catégorie',
            'plat' => $plat->load(['categorie', 'ingredients']),
        ], 201);
    }
}
