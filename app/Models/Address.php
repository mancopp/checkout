<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['country', 'city', 'zipcode', 'address'];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
