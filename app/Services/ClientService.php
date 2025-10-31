<?php

namespace App\Services;

use App\Models\Client;

class ClientService
{
    public function __construct(
        protected Client $clientModel
    ) {}

    public function fromId(int $id): Client
    {
        $client = $this->clientModel->find($id);

        if (empty($client)) {
            throw new \Exception('Client not found.');
        }

        return $client;
    }

    public function paginated()
    {
        return $this->clientModel->paginate(10);
    }
}
