<?php

namespace App\Http\Controllers;

use App\Models\DeliveryMethod;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class GetDataController extends Controller
{
    public function getData()
    {
        // $deliveryOptions = DeliveryMethod::select('name', 'price', 'icon_link')->get();
        // $paymentOptions = PaymentMethod::select('name', 'icon_link')->get();

        // return response()->json([
        //     'deliveryOptions' => $deliveryOptions,
        //     'paymentOptions' => $paymentOptions,
        // ]);

        $deliveryOptions = DeliveryMethod::all();
        $paymentOptions = PaymentMethod::with('deliveryMethods')->get();

        return response()->json([
            'deliveryOptions' => $deliveryOptions,
            'paymentOptions' => $paymentOptions,
        ]);
    }
}
