<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['name', 'icon_link'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function deliveryMethods()
    {
        return $this->belongsToMany(DeliveryMethod::class, 'delivery_method_payment_method');
    }
}
