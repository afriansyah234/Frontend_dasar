<?php

namespace App\Contracts\Interfaces;

interface ApiInterface
{
    public function all(): array;
    public function find(int $id): array;
    public function create(array $data): array;
    public function update(int $id, array $data): array;
    public function delete(int $id): bool;
}
