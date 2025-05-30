<?php

namespace App\Modules\Client\Http\Controllers;

use App\Modules\Client\Http\Requests\ClientRequest;
use App\Modules\Client\Http\Requests\ClientUpdateRequest;
use App\Modules\Client\Interfaces\ClientServiceInterface;

class ClientController
{
    private ClientServiceInterface $clientService;

    public function __construct(ClientServiceInterface $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index()
    {
        return $this->clientService->getAllClients();
    }

    public function store(ClientRequest $request)
    {
        return $this->clientService->createClient($request);
    }

    public function show(int $id)
    {
        return $this->clientService->getClientById($id);
    }

    public function update(ClientUpdateRequest $request, int $id)
    {
        return $this->clientService->updateClient($request, $id);
    }

    public function destroy(int $id)
    {
        return $this->clientService->deleteClient($id);
    }
}
