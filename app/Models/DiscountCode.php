<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    protected $fillable = ['code', 'discount', 'isValid'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

