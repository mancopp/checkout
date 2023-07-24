<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\DiscountCode;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\DeliveryMethod;
use App\Rules\ValidDeliveryPaymentCombination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class FormController extends Controller
{
    public function submitForm(Request $request)
    {
       $validatedData = $request->validate([
        'email' => [
            'required',
            'email',
            Rule::unique('customers'),
        ],
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'different_delivery_address' => ['required', 'boolean'],
        'password' => 'required|string|max:255',

        'delivery_method' => [
            'required',
            Rule::in(DeliveryMethod::pluck('id')->all()),
        ],
        'payment_method' => [
            'required',
            Rule::in(PaymentMethod::pluck('id')->all()),
            new ValidDeliveryPaymentCombination,
        ],
        'discount_code' => [
            'nullable',
            Rule::exists('discount_codes', 'code')->where(function ($query) {
                return $query->where('active', true);
            }),
        ],
        'products_list' => [
            'required',
            'array',
        ],
        'products_list.*.id' => [
            'required',
            'exists:products,id'
        ],
        'products_list.*.quantity' => [
            'required',
            'integer',
            'min:1'
        ],
        //TODO
        'order_comments' => 'required|string|max:255',

        'address_data_account.selectedCountry' => 'required|string',
        'address_data_account.address' => 'required|string',
        'address_data_account.zipCode' => 'required|string|regex:/^\d{2}-\d{3}$/',
        'address_data_account.city' => 'required|string|max:255',

        'address_data_delivery.selectedCountry' => ['required_if:different_delivery_address,true'],
        'address_data_delivery.address' => ['required_if:different_delivery_address,true', 'max:255'],
        'address_data_delivery.zipCode' => ['required_if:different_delivery_address,true', 'regex:/^\d{2}-\d{3}$/', 'nullable'],
        'address_data_delivery.city' => ['required_if:different_delivery_address,true', 'string', 'max:255', 'nullable'],
        
        'phone_number' => 'required|regex:/^\d{3}-\d{3}-\d{3}$/',
        'newsletter_subscription' => 'required|boolean',
    ]);

    $accountAddress = $this->createOrRetrieveAddress($validatedData['address_data_account']);
    
    $customer = Customer::create([
        'email' => $validatedData['email'],
        'first_name' => $validatedData['first_name'],
        'last_name' => $validatedData['last_name'],
        'password' => Hash::make($validatedData['password']),
        'phone_number' => $validatedData['phone_number'],
        'newsletter_subscription' => $validatedData['newsletter_subscription'],
        'address_id' => $accountAddress->id,
    ]);

    $discountCode = DiscountCode::where('code', $validatedData['discount_code'])->first();

    $staticOrderParams = [
        'customer_id' => $customer->id,
        'delivery_method_id' => $validatedData['delivery_method'],
        'payment_method_id' => $validatedData['payment_method'],
        'discount_code_id' => $discountCode->id ?? null,
        'order_comments' => $validatedData['order_comments'],
    ];

    $address = $accountAddress;

    if ($validatedData['different_delivery_address'] && $validatedData['address_data_account'] != $validatedData['address_data_delivery']) {

        $deliveryAddress=$this->createOrRetrieveAddress($validatedData['address_data_delivery']);
        $address = $deliveryAddress;
    }

    $order = Order::create([
        'address_id' => $address->id,
        ...$staticOrderParams,
    ]);

        foreach ($validatedData['products_list'] as $productData) {
            $productId = $productData['id'];
            $quantity = $productData['quantity'];

            $product = Product::find($productId);
            if ($product) {
                $order->products()->attach([
                    $productId => ['quantity' => $quantity],
                ]);
            }
        }


        return response()->json($order->id, 200);
    }

    private function createOrRetrieveAddress(array $addressDataRaw)
    {
        $addressDataFormed = [
            'country' => $addressDataRaw['selectedCountry'],
            'address' => $addressDataRaw['address'],
            'zipcode' => $addressDataRaw['zipCode'],
            'city' => $addressDataRaw['city'],
        ];
        $existingAddress = Address::where($addressDataFormed)->first();

        if ($existingAddress) return $existingAddress;

        return Address::create($addressDataFormed);
    }

}

