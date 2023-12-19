<?php

namespace App\Modules\Auth\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Modules\Directories\Models\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ACTIVE = 1;
    const UNACTIVE = 0;
    const WINDOW_LOGIN_FAST_CODE = 'WINDOW_LOGIN_FAST_CODE';
    const WINDOW_SMS = 'WINDOW_SMS';
    const WINDOW_REGISTRATION = 'WINDOW_REGISTRATION';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lastname',
        'firstname',
        'middlename',
        'city_id',
        'street',
        'house_number',
        'apt',
        'school_id',
        'class',
        'letter',
        'birthday',
        'photo',
        'mobile',
        'password',
        'gender_id',
        'fast_code',
        'save_interface',
        'last_login',
        'login_type',
        'is_confirmed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'updated_at',
        'fast_code',
        'save_interface',
        'sms',
        'pivot'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'iin' => 'array',
        'roles' => 'array'
    ];

    public function rolesOfUser(): BelongsToMany
    {
        return $this->belongsToMany(Role::class,'role_user','user_id','role_id');
    }

    public function RoleUser()
    {
       return $this->hasMany(RoleUser::class,'user_id','id');
    }

    public function iins(): HasMany
    {
        return $this->hasMany(Iin::class);
    }

    public function userSubject()
    {
       return $this->hasMany(UserSubject::class,'user_id','id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class,'user_subject','user_id','subject_id');
    }
}
