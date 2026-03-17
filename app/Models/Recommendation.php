<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plate_id',
        'score',
        'label',
        'warning_message',
        'status',
    ];

    protected $casts = [
        'score' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plat()
    {
        return $this->belongsTo(Plat::class, 'plate_id');
    }
}