<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use Illuminate\Http\Request;

class DiscountCodeController extends Controller
{
    public function checkDiscountCode(Request $request)
    {
        $discountCode = $request->input('discountCode');

        $discount = DiscountCode::where('code', $discountCode)->first();

        if ($discount) {
            if ($discount->active) {
                return response()->json([
                    'isValid' => true,
                    'isActive' => true,
                    'discountValue' => $discount->discount,
                ]);
            } else {
                return response()->json(['isValid' => true, 'isActive' => false]);
            }
        } else {
            return response()->json(['isValid' => false]);
        }
    }

}
