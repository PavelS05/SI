<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Costumer.php
class Costumer extends Model
{
    protected $fillable = [
        'name',
        'dbo',
        'contact_name',
        'phone',
        'email',
        'credit',
        'sales_rep1',
        'sales_rep2',
        'status'
    ];

    // Relație cu loads
    public function loads()
    {
        return $this->hasMany(Load::class, 'costumer', 'id');
    }
}