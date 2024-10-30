<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Carrier.php
class Carrier extends Model
{
    protected $fillable = [
        'name',
        'dbo',
        'mc',
        'contact_name',
        'phone',
        'email',
        'insurance',
        'notes'
    ];

    // Relație cu loads
    public function loads()
    {
        return $this->hasMany(Load::class, 'carrier', 'id');
    }
}