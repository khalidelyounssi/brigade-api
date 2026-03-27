<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plat extends Model
{
    use HasFactory;

    protected $table = 'plates';

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'is_available',
        'category_id',
        'user_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'category_id');
    }

    public function ingredients()
    {
        return $this->belongsToMany(
            Ingredient::class,
            'ingredient_plate',
            'plate_id',
            'ingredient_id'
        );
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'plate_id');
    }
}
