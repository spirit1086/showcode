<?php

namespace App\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsUser extends Model
{
    use HasFactory;

    protected $table = 'sms_user';

    protected $fillable = [
        'mobile',
        'sms',
        'sms_created',
        'is_sms_verify',
        'tmp_token',
        'tmp_token_created'
    ];
}
