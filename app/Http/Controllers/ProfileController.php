<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'dietary_tags' => ['required', 'array']
        ]);

        $user = $request->user();
        $user->update($data);

        return response()->json([
            'message' => 'Profile updated',
            'user' => $user
        ]);
    }
}