<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PlatController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        return Plat::where('user_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Plat::class);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id'
        ]);

        $plat = Plat::create([
            'name'=>$data['name'],
            'description'=>$data['description'],
            'price'=>$data['price'],
            'category_id'=>$data['category_id'],
            'user_id'=>auth()->id()
        ]);

        return response()->json($plat,201);
    }

    public function show(Plat $plat)
    {
        $this->authorize('view',$plat);

        return response()->json($plat);
    }

    public function update(Request $request, Plat $plat)
    {
        $this->authorize('update',$plat);

        $data = $request->validate([
            'name'=>'string|max:255',
            'description'=>'nullable|string',
            'price'=>'numeric',
            'category_id'=>'exists:categories,id'
        ]);

        $plat->update($data);

        return response()->json($plat);
    }

    public function destroy(Plat $plat)
    {
        $this->authorize('delete',$plat);

        $plat->delete();

        return response()->json([
            'message'=>'Plat deleted'
        ]);
    }
    public function storeByCategory(Request $request, $categorieId)
{
    $this->authorize('create', Plat::class);

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric'
    ]);

    $plat = Plat::create([
        'name' => $data['name'],
        'description' => $data['description'],
        'price' => $data['price'],
        'category_id' => $categorieId,
        'user_id' => auth()->id()
    ]);

    return response()->json([
        'message' => 'Plat ajouté à la catégorie',
        'plat' => $plat
    ], 201);
}
}