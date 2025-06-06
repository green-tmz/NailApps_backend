<?php

namespace App\Modules\Client\Repositories;

use App\Modules\Client\Interfaces\ClientRepositoryInterface;
use App\Modules\Client\Models\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ClientRepository implements ClientRepositoryInterface
{
    public function getAllWithUser(): Collection
    {
        return Client::where('user_id', '=', Auth::user()->id)
            ->with('user')
            ->get();
    }

    public function create(array $data): Client
    {
        return Client::create($data);
    }

    public function getByIdWithUser(int $id): Client
    {
        return Client::with('user')->findOrFail($id);
    }

    public function update(Client $client, array $data): Client
    {
        $client->update($data);

        return $client;
    }

    public function delete(Client $client): void
    {
        $client->delete();
    }
}
