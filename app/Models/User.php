<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    protected $fillable = [
        'username',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Load-uri unde userul este sales
    public function salesLoads()
    {
        return $this->hasMany(Load::class, 'sales', 'username');
    }

    // Load-uri unde userul este dispatcher
    public function dispatcherLoads()
    {
        return $this->hasMany(Load::class, 'dispatcher', 'username');
    }
}
