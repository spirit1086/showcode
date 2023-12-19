<?php

namespace App\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    const IS_ACTIVE_INDEX = 1;

    protected $table = 'permissions';

    protected $hidden = ['pivot','created_at','updated_at'];

    protected $fillable = [
        'title',
        'alias',
        'is_active',
        'module_name'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class,'permission_role');
    }
}
