<?php

namespace Database\Seeders;

use App\Models\DeliveryMethod;
use App\Models\DiscountCode;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialSeeder extends Seeder
{

    public function run(): void
    {
        DiscountCode::create([
            'code' => 'valid',
            'discount' => 15.99,
            'active' => true,
        ]);

        DiscountCode::create([
            'code' => 'notvalid',
            'discount' => 15.99,
            'active' => false,
        ]);

        Product::create([
            'id' => 1,
            'name' => 'Portable laptop',
            'price' => '115.99',
            'icon_link' => 'https://upload.wikimedia.org/wikipedia/commons/2/25/Laptop_z_tack%C4%85.svg'
        ]);

        Product::create([
            'id' => 2,
            'name' => 'Computer mouse',
            'price' => '27.99',
            'icon_link' => 'https://upload.wikimedia.org/wikipedia/commons/2/22/3-Tasten-Maus_Microsoft.jpg'
        ]);
        
        $paczkomatyDeliveryMethod = DeliveryMethod::create([
            'id' => 1,
            'icon_link' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c5/InPost_logo.svg/2560px-InPost_logo.svg.png',
            'name' => 'Paczkomaty 24/7',
            'price' => 10.99
        ]);

        $kurierDPDDeliveryMethod = DeliveryMethod::create([
            'id' => 2,
            'icon_link' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ab/DPD_logo_%282015%29.svg/1280px-DPD_logo_%282015%29.svg.png',
            'name' => 'Kurier DPD',
            'price' => 18.00
        ]);

        $kurierDPDPobranieDeliveryMethod = DeliveryMethod::create([
            'id' => 3,
            'icon_link' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ab/DPD_logo_%282015%29.svg/1280px-DPD_logo_%282015%29.svg.png',
            'name' => 'Kurier DPD Pobranie',
            'price' => 22.00
        ]);

        $payUPaymentMethod = PaymentMethod::create([
            'id' => 1,
            'icon_link' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/PayU.svg/2560px-PayU.svg.png',
            'name' => 'PayU'
        ]);

        $przelewBankowyPaymentMethod = PaymentMethod::create([
            'id' => 2,
            'icon_link' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Wallet_Flat_Icon.svg/2048px-Wallet_Flat_Icon.svg.png',
            'name' => 'Przełew bankowy'
        ]);

        $platnoscPrzyOdbiorzePaymentMethod = PaymentMethod::create([
            'id' => 3,
            'icon_link' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Wallet_Flat_Icon.svg/2048px-Wallet_Flat_Icon.svg.png',
            'name' => 'Płatność przy odbiorze'
        ]);

        $paczkomatyDeliveryMethod->paymentMethods()->attach($payUPaymentMethod);
        $paczkomatyDeliveryMethod->paymentMethods()->attach($przelewBankowyPaymentMethod);

        $kurierDPDDeliveryMethod->paymentMethods()->attach($payUPaymentMethod);
        $kurierDPDDeliveryMethod->paymentMethods()->attach($przelewBankowyPaymentMethod);
        $kurierDPDDeliveryMethod->paymentMethods()->attach($platnoscPrzyOdbiorzePaymentMethod);

        $kurierDPDPobranieDeliveryMethod->paymentMethods()->attach($payUPaymentMethod);
        $kurierDPDPobranieDeliveryMethod->paymentMethods()->attach($przelewBankowyPaymentMethod);
        $kurierDPDPobranieDeliveryMethod->paymentMethods()->attach($platnoscPrzyOdbiorzePaymentMethod);
    }
}
