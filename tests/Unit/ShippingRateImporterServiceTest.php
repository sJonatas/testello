<?php

namespace Tests\Unit;

use App\Models\ShippingRate;
use App\Services\ShippingRateImporterService;
use App\Services\ShippingRateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ShippingRateImporterServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_throws_without_client()
    {
        $service = App::make(ShippingRateImporterService::class);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('The client id must be provided.');

        $service->import('/tmp/dummy.csv');
    }

    public function test_collection_creates_and_updates_rows_via_service()
    {
        $realQuery = (new ShippingRate)->query();

        $mockService = $this->partialMock(ShippingRateService::class, function ($mock) use ($realQuery) {
            $mock->shouldReceive('fromClient')->andReturn($realQuery);
            $mock->shouldReceive('save')->twice()->andReturnTrue();
        });

        $service = new ShippingRateImporterService($mockService);
        $service->forClient(1);

        $rows = new Collection([
            [
                'id' => null,
                'client_id' => 1,
                'from_postcode' => '1000',
                'to_postcode' => '2000',
                'from_weight' => '0',
                'to_weight' => '1',
                'cost' => 10.0,
                'branch' => 1,
            ],
            [
                'id' => null,
                'client_id' => 1,
                'from_postcode' => '3000',
                'to_postcode' => '4000',
                'from_weight' => '0',
                'to_weight' => '2',
                'cost' => 20.0,
                'branch' => 1,
            ],
        ]);

        // Seed an existing client and row so the first item exercises the update path
        $client = \App\Models\Client::factory()->create(['id' => 1]);
        ShippingRate::create([
            'client_id' => $client->id,
            'from_postcode' => '1000',
            'to_postcode' => '2000',
            'from_weight' => '0',
            'to_weight' => '1',
            'cost' => 5.0,
            'branch' => 1,
        ]);

        $service->collection($rows);
    }
}
