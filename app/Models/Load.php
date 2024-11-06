<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Load extends Model
{
    protected $fillable = [
        'load_number',
        'sales',
        'dispatcher',
        'customer',
        'customer_rate',
        'carrier',
        'carrier_rate',
        'equipment_type',  
        'driver_name',     
        'driver_contact',  
        'service',
        'shipper_name',
        'shipper_address',
        'pu_date',
        'po',
        'pu_appt',
        'receiver_name',
        'receiver_address',
        'del_date',
        'del',
        'del_appt',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($load) {
            if (!$load->load_number) {
                $lastLoad = static::orderBy('id', 'desc')->first();
                $number = $lastLoad ? intval(substr($lastLoad->load_number, 1)) + 1 : 1000000;
                $load->load_number = 'A' . str_pad($number, 7, '0', STR_PAD_LEFT);
            }
        });
    }

    // Relație cu carrier
    public function carrierRelation()
    {
        return $this->belongsTo(Carrier::class, 'carrier');
    }

    // Relație cu customer
    public function customerRelation()
    {
        return $this->belongsTo(Customer::class, 'customer');
    }

    // Relație cu user (sales)
    public function salesUser()
    {
        return $this->belongsTo(User::class, 'sales', 'username');
    }

    // Relație cu user (dispatcher)
    public function dispatcherUser()
    {
        return $this->belongsTo(User::class, 'dispatcher', 'username');
    }
}