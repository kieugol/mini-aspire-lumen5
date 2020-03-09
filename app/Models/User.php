<?php

namespace App\Models;


class User extends BaseModel
{
    protected $table = 'user';
    
    protected $fillable = [
        'name',
        'email',
        'birthday',
        'phone',
        'address',
        'is_active',
        'is_delete',
        'created_by',
        'updated_by'
    ];
    
    protected $hidden = [
    ];
    
    public function loan()
    {
        return $this->hasMany(Loan::class, 'user_id')->select(['id', 'client_id', 'user_id']);
    }
}
