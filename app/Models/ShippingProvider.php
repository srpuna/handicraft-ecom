<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingProvider extends Model
{
    protected $guarded = [];

    public function rates()
    {
        return $this->hasMany(ShippingRate::class);
    }
}
