<?php

namespace App\Modules\Client\Services;

use App\Modules\Client\Http\Requests\ClientRequest;
use App\Modules\Client\Http\Requests\ClientUpdateRequest;
use App\Modules\Client\Http\Resources\ClientResource;
use App\Modules\Client\Interfaces\ClientRepositoryInterface;
use App\Modules\Client\Interfaces\ClientServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class ClientService implements ClientServiceInterface
{
    private ClientRepositoryInterface $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function getAllClients(): AnonymousResourceCollection
    {
        $clients = $this->clientRepository->getAllWithUser();

        return ClientResource::collection($clients);
    }

    public function createClient(ClientRequest $request): ClientResource
    {
        $client = $this->clientRepository->create($request->validated());

        return new ClientResource($client);
    }

    public function getClientById(int $id): ClientResource
    {
        $client = $this->clientRepository->getByIdWithUser($id);

        return new ClientResource($client);
    }

    public function updateClient(ClientUpdateRequest $request, int $id): ClientResource
    {
        $client = $this->clientRepository->getByIdWithUser($id);
        $updatedClient = $this->clientRepository->update($client, $request->validated());

        return new ClientResource($updatedClient);
    }

    public function deleteClient(int $id): array
    {
        $client = $this->clientRepository->getByIdWithUser($id);
        if ($client->user->id != Auth::user()->id) {
            return ['message' => 'Ошибка удаления клиента'];
        };
        $this->clientRepository->delete($client);

        return ['message' => 'Клиент успешно удален'];
    }
}
