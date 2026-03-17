<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function plats()
    {
        return $this->belongsToMany(
            Plat::class,
            'ingredient_plate',
            'ingredient_id',
            'plate_id'
        );
    }
}