<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;

class User extends BaseModel implements CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    
    protected $table = 'user';
    protected $fillable = [
        'id',
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'full_name',
        'birthday',
        'phone',
        'address',
        'is_active',
        'is_delete',
        'created_by',
        'updated_by'
    ];
    
    protected $hidden = [
        'password',
    ];
}
