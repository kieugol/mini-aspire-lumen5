<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Passwords\CanResetPassword;

class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, JWTSubject
{
    use Authenticatable, Authorizable, CanResetPassword;
    
    protected $table = 'user';
    protected $fillable = [
        'id',
        'is_master',
        'roles_id',
        'username',
        'email',
        'password',
        'original_password',
        'avatar',
        'first_name',
        'last_name',
        'full_name',
        'birthday',
        'phone',
        'phone2',
        'address',
        'gender',
        'is_active',
        'fax',
        'website',
        'created_by',
        'updated_by'
    ];
    
    protected $hidden = [
        'password',
        'original_password',
    ];
    
    public function getAuthPassword() {
        return $this->password;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    public function roles() {
        return $this->belongsTo(Roles::class, 'roles_id');
    }
}
