<?php

namespace App\Policies;

use App\Models\Categorie;
use App\Models\User;

class CategoriePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Categorie $categorie): bool
    {
        return $user->id === $categorie->user_id || $user->role === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Categorie $categorie): bool
    {
        return $user->role === 'admin' && $user->id === $categorie->user_id;
    }

    public function delete(User $user, Categorie $categorie): bool
    {
        return $user->role === 'admin' && $user->id === $categorie->user_id;
    }
}