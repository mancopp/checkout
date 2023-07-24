<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\DeliveryMethod;
use App\Models\PaymentMethod;
use App\Models\DiscountCode;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
public function acceptJson(Request $request)
    {
        $data = $request->json()->all();

        $rules = [
            'first_name' => 'required|regex:/^[\p{L}\p{M}\u0027\s-]+$/u',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
            return response()->json(['status' => 'success', 'message' => 'JSON data is valid'], 200);
        } else {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
    }
}
