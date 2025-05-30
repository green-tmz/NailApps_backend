<?php

namespace App\Modules\Client\Interfaces;

use App\Modules\Client\Http\Requests\ClientRequest;
use App\Modules\Client\Http\Requests\ClientUpdateRequest;
use App\Modules\Client\Http\Resources\ClientResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface ClientServiceInterface
{
    public function getAllClients(): AnonymousResourceCollection;
    public function createClient(ClientRequest $request): ClientResource;
    public function getClientById(int $id): ClientResource;
    public function updateClient(ClientUpdateRequest $request, int $id): ClientResource;
    public function deleteClient(int $id): array;
}
