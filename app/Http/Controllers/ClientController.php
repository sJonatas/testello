<?php

namespace App\Http\Controllers;

use App\Services\ClientService;
use App\Services\ShippingRateService;

class ClientController extends Controller
{
    public function __construct(
        protected ClientService $clientService
    ) {}

    public function index()
    {
        return view('clients.index', ['clients' => $this->clientService->paginated()]);
    }

    public function shippingRateList(int $clientId, ShippingRateService $shippingRateService)
    {
        $client = $this->clientService->fromId($clientId);

        return view('clients.shipping_rates', [
            'rates' => $shippingRateService->fromClient($clientId)->paginate(100),
            'client' => $client,
        ]);
    }
}
