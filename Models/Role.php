<?php

namespace App\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['title','alias','is_active'];

    const ROLE_SUPERADMIN = 'superAdmin';
    const ROLE_USER = 'user';
    const ROLE_CLASSROOM_TEACHER = 'classroom_teacher';
    const IS_ACTIVE_INDEX = 1;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'role_user','role_id','user_id');
    }

    protected $hidden = ['pivot','created_at','updated_at'];

    protected $casts = [
        'user_permissions' => 'array'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'permission_role');
    }

    public function permissionRole()
    {
        return $this->hasMany(PermissionRole::class);
    }
}
