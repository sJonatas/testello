<?php

namespace Tests\Unit;

use App\Dto\ShippingRateDto;
use App\Models\ShippingRate;
use App\Services\ShippingRateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShippingRateServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_from_client_filters_by_client_id()
    {
        $client1 = \App\Models\Client::factory()->create();
        $client2 = \App\Models\Client::factory()->create();

        ShippingRate::create([
            'client_id' => $client1->id,
            'from_postcode' => '1000',
            'to_postcode' => '2000',
            'from_weight' => '0',
            'to_weight' => '1',
            'cost' => 10.0,
            'branch' => 1,
        ]);
        ShippingRate::create([
            'client_id' => $client2->id,
            'from_postcode' => '3000',
            'to_postcode' => '4000',
            'from_weight' => '0',
            'to_weight' => '1',
            'cost' => 12.5,
            'branch' => 1,
        ]);

        $service = new ShippingRateService(new ShippingRate);
        $client1Rates = $service->fromClient($client1->id)->get();

        $this->assertCount(1, $client1Rates);
        $this->assertEquals(1, $client1Rates->first()->client_id);
    }

    public function test_save_persists_shipping_rate_from_dto()
    {
        $client = \App\Models\Client::factory()->create();
        $service = new ShippingRateService(new ShippingRate);

        $dto = new ShippingRateDto(
            id: null,
            clientId: $client->id,
            fromPostCode: '5000',
            toPostCode: '6000',
            fromWeight: '0',
            toWeight: '5',
            cost: 25.75,
            branch: 1,
        );

        // Exercise
        $service->save($dto);

        // Verify
        $this->assertDatabaseHas('shipping_rates', [
            'client_id' => $client->id,
            'from_postcode' => '5000',
            'to_postcode' => '6000',
            'from_weight' => '0',
            'to_weight' => '5',
            'cost' => 25.75,
            'branch' => 1,
        ]);
    }
}
