<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Rules\ValidDeliveryPaymentCombination;

class ValidDeliveryPaymentCombinationRuleTest extends TestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        return $app;
    }

    public function testValidCombination()
    {
        DB::shouldReceive('table->where->where->exists')->once()->andReturn(true);

        $validator = Validator::make(
            ['delivery_method' => 1, 'payment_method' => 6],
            ['payment_method' => new ValidDeliveryPaymentCombination]
        );

        $this->assertTrue($validator->passes());
    }
}
