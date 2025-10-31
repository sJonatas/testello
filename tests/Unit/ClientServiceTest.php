<?php

namespace Tests\Unit;

use App\Enum\Statuses;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_from_id_returns_client()
    {
        $client = Client::create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'status' => Statuses::Ativo,
            'email' => 'jane@example.com',
        ]);

        $service = new ClientService(new Client);
        $found = $service->fromId($client->id);

        $this->assertSame($client->id, $found->id);
        $this->assertEquals('Jane Doe', $found->full_name);
    }

    public function test_from_id_throws_when_missing()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Client not found.');

        $service = new ClientService(new Client);
        $service->fromId(9999);
    }

    public function test_paginated_returns_length_aware_paginator()
    {
        Client::factory()->count(15)->create();

        $service = new ClientService(new Client);
        $paginator = $service->paginated();

        $this->assertEquals(10, $paginator->perPage());
        $this->assertEquals(2, $paginator->lastPage());
        $this->assertCount(10, $paginator->items());
    }
}
