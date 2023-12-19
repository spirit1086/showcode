<?php

namespace App\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    use HasFactory;

    protected $table = 'permission_role';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'permission_id',
        'role_id'
    ];
}
