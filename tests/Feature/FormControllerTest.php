<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Customer;
use App\Models\Product;
use App\Models\DiscountCode;
use App\Models\PaymentMethod;
use App\Models\DeliveryMethod;
use Database\Seeders\InitialSeeder;

class FormControllerTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * Test submitting the form with valid data.
     *
     * @return void
     */
    public function testSubmitFormWithValidData()
    {
        $validData = [
            'email' => 'test1@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'different_delivery_address' => true,
            'password' => 'password123',
            'delivery_method' => DeliveryMethod::first()->id,
            'payment_method' => PaymentMethod::first()->id,
            'discount_code' => null, 
            'products_list' => [
                ['id' => Product::first()->id, 'quantity' => 2],
                ['id' => Product::find(2)->id, 'quantity' => 1],
            ],
            'order_comments' => 'Test order comments',
            'address_data_account' => [
                'selectedCountry' => 'Poland',
                'address' => '123 Main St',
                'zipCode' => '12-345',
                'city' => 'New York',
            ],
            'address_data_delivery' => [
                'selectedCountry' => 'Canada',
                'address' => '456 Secondary St',
                'zipCode' => '67-890',
                'city' => 'Toronto',
            ],
            'phone_number' => '123-456-789',
            'newsletter_subscription' => true,
        ];

        $response = $this->json('POST', 'api/submit-form', $validData);
        $response->assertStatus(200);
    }

    /**
     * Test submitting the form with valid data and different_delivery_address set to false.
     *
     * @return void
     */
    public function testSubmitFormWithValidDataSameAddress()
    {

        $validData = [
            'email' => 'test2@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'different_delivery_address' => false,
            'password' => 'password123',
            'delivery_method' => DeliveryMethod::first()->id,
            'payment_method' => PaymentMethod::first()->id,
            'discount_code' => null, 
            'products_list' => [
                ['id' => Product::first()->id, 'quantity' => 1],
            ],
            'order_comments' => 'Test order comments',
            'address_data_account' => [
                'selectedCountry' => 'Poland',
                'address' => '123 Main St',
                'zipCode' => '12-345',
                'city' => 'New York',
            ],
            'address_data_delivery' => [
                'selectedCountry' => null,
                'address' => null,
                'zipCode' => null,
                'city' => null,
            ],
            'phone_number' => '123-456-789',
            'newsletter_subscription' => true,
        ];

        $response = $this->json('POST', 'api/submit-form', $validData);

        $response->assertStatus(200);
    }

    /**
     * Test submitting the form with invalid data.
     *
     * @return void
     */
    public function testSubmitFormWithInvalidData()
    {

        $validData = [
            'email' => 'testexamplecom',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'different_delivery_address' => false,
            'password' => 'password123',
            'delivery_method' => DeliveryMethod::first()->id,
            'payment_method' => PaymentMethod::first()->id,
            'discount_code' => null, 
            'products_list' => [
                ['id' => Product::first()->id, 'quantity' => 1],
            ],
            // This text has more than 255 chars
            'order_comments' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, asets h',
            'address_data_account' => [
                'selectedCountry' => 'Poland',
                'address' => '123 Main St',
                'zipCode' => '12345',
                'city' => 'New York',
            ],
            'address_data_delivery' => [
                'selectedCountry' => 'Canada',
                'address' => '456 Secondary St',
                'zipCode' => '67890',
                'city' => 'Toronto',
            ],
            'phone_number' => '123456789',
            'newsletter_subscription' => false,
        ];

        $response = $this->json('POST', 'api/submit-form', $validData);

        $response->assertStatus(200);
    }

    /**
     * Test submitting the form with invalid delivery-payment relation.
     *
     * @return void
     */
    public function testSubmitFormWithInvalidDelivery()
    {

        $validData = [
            'email' => 'test4@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'different_delivery_address' => true,
            'password' => 'password123',
            'delivery_method' => DeliveryMethod::first()->id,
            'payment_method' => PaymentMethod::find(3)->id,
            'discount_code' => null, 
            'products_list' => [
                ['id' => Product::first()->id, 'quantity' => 2],
                ['id' => Product::find(2)->id, 'quantity' => 4],
            ],
            'order_comments' => 'Test order comments',
            'address_data_account' => [
                'selectedCountry' => 'Poland',
                'address' => '123 Main St',
                'zipCode' => '12-345',
                'city' => 'New York',
            ],
            'address_data_delivery' => [
                'selectedCountry' => 'Canada',
                'address' => '456 Secondary St',
                'zipCode' => '67-890',
                'city' => 'Toronto',
            ],
            'phone_number' => '123-456-789',
            'newsletter_subscription' => true,
        ];

        $response = $this->json('POST', 'api/submit-form', $validData);

        $response->assertStatus(200);
    }

}
