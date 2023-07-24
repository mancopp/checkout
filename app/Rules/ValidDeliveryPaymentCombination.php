<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidDeliveryPaymentCombination implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $deliveryMethod = request('delivery_method');
        $paymentMethod = request('payment_method');

        $exists = DB::table('delivery_method_payment_method')
            ->where('delivery_method_id', $deliveryMethod)
            ->where('payment_method_id', $paymentMethod)
            ->exists();

        if(!$exists) $fail('Illegal combination of delivery_method and payment_method.');
    }
}
