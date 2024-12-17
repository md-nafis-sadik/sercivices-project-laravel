<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'payment_status',
        'order_date',
        'expiry_date',
        'delivery_method',
        'delivery_status',
        'flight_number',
        'departure_date',
        'vehicle_number',
        'driver_name',
        'estimated_arrival',
        'home_delivery',
        'home_address',
        'ship_name',
        'port_of_origin',
        'port_of_destination',
        'by_agency',
        'agency_name',
        'agency_contact',
    ];

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with plan
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // Define the relationship with the Payment model
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id'); // Assuming 'order_id' is the foreign key in payments table
    }
}
