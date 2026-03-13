<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PlatController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        return response()->json(
            Plat::where('user_id', auth()->id())->get()
        );
    }

    public function store(Request $request)
    {
        $this->authorize('create', Plat::class);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'nullable|image'
        ]);

        if ($request->hasFile('image')) {
            $imageUrl = Cloudinary::upload(
                $request->file('image')->getRealPath()
            )->getSecurePath();

            $data['image'] = $imageUrl;
        }

        $data['user_id'] = auth()->id();

        $plat = Plat::create($data);

        return response()->json($plat, 201);
    }

    public function show(Plat $plat)
    {
        $this->authorize('view', $plat);

        return response()->json($plat);
    }

    public function update(Request $request, Plat $plat)
    {
        $this->authorize('update', $plat);

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|numeric',
            'category_id' => 'sometimes|integer|exists:categories,id',
            'image' => 'sometimes|nullable|image'
        ]);

        if ($request->hasFile('image')) {
            $imageUrl = Cloudinary::upload(
                $request->file('image')->getRealPath()
            )->getSecurePath();

            $data['image'] = $imageUrl;
        }

        $plat->update($data);

        return response()->json($plat);
    }

    public function destroy(Plat $plat)
    {
        $this->authorize('delete', $plat);

        $plat->delete();

        return response()->json([
            'message' => 'Plat deleted'
        ]);
    }

    public function storeByCategory(Request $request, $categorieId)
    {
        $this->authorize('create', Plat::class);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image'
        ]);

        if ($request->hasFile('image')) {
            $imageUrl = Cloudinary::upload(
                $request->file('image')->getRealPath()
            )->getSecurePath();

            $data['image'] = $imageUrl;
        }

        $data['category_id'] = $categorieId;
        $data['user_id'] = auth()->id();

        $plat = Plat::create($data);

        return response()->json([
            'message' => 'Plat ajouté à la catégorie',
            'plat' => $plat
        ], 201);
    }
}