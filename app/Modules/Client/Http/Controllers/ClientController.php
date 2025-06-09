<?php

namespace App\Modules\Client\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Modules\Client\Http\Resources\ClientResource;
use App\Modules\Client\Http\Requests\ClientRequest;
use App\Modules\Client\Http\Requests\ClientUpdateRequest;
use App\Modules\Client\Interfaces\ClientServiceInterface;

readonly class ClientController
{
    public function __construct(private ClientServiceInterface $clientService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return $this->clientService->getAllClients();
    }

    public function store(ClientRequest $request): ClientResource
    {
        return $this->clientService->createClient($request);
    }

    public function show(int $id): ClientResource
    {
        return $this->clientService->getClientById($id);
    }

    public function update(ClientUpdateRequest $request, int $id): ClientResource
    {
        return $this->clientService->updateClient($request, $id);
    }

    public function destroy(int $id): array
    {
        return $this->clientService->deleteClient($id);
    }
}
