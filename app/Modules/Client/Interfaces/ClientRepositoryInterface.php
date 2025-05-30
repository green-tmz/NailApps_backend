<?php

namespace App\Modules\Client\Interfaces;

use App\Modules\Client\Models\Client;
use Illuminate\Support\Collection;

interface ClientRepositoryInterface
{
    public function getAllWithUser(): Collection;
    public function create(array $data): Client;
    public function getByIdWithUser(int $id): Client;
    public function update(Client $client, array $data): Client;
    public function delete(Client $client): void;
}
