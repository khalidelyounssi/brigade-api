<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'dietary_tags' => $user->dietary_tags ?? [],
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ],
        ], 200);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'dietary_tags' => ['sometimes', 'array'],
            'dietary_tags.*' => ['string', 'max:100'],
        ]);

        $user = $request->user();
        $user->update($data);
        $user->refresh();

        return response()->json([
            'message' => 'Profile updated',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'dietary_tags' => $user->dietary_tags ?? [],
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ],
        ], 200);
    }
}
