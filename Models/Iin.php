<?php

namespace App\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iin extends Model
{
    use HasFactory;

    protected $table = 'iins';
    protected $fillable = [
        'user_iin',
        'user_id'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
