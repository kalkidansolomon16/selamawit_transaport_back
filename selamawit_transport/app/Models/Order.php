<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'order_name',
    'vehicle_id',
    'client_name',
    'plate_number',
    'driver_name',
    'phone_number',
    'loading_place',
    'destination', 
    'load_type',
    'quintal',
    'given_tariff',
    'sub_tariff',
    'total_revenue',
    'revenue',
    'to_be_paid',
    'arrival_at_loading_site',
    'loading_date',
    'current_condition',
    'truks_owner',
    'payment_collected',
    'month'

       
    ];
}
