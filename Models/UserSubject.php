<?php

namespace App\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubject extends Model
{
    use HasFactory;

    protected $table = 'user_subject';
    protected $fillable = [
        'user_id',
        'subject_id'
    ];
    public $timestamps = false;
    public $incrementing = false;
}
