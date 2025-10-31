<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    protected $fillable = [
        'id',
        'client_id',
        'from_postcode',
        'to_postcode',
        'from_weight',
        'to_weight',
        'cost',
        'branch',
    ];
}
