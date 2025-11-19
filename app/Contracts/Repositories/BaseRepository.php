<?php

namespace App\Repositories;

use App\Contracts\Interfaces\ApiInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class BaseRepository implements ApiInterface
{
    protected string $baseUrl;
    protected string $endpoint;

    public function __construct()
    {
        // Ambil base URL dari config
        $this->baseUrl = rtrim(config('services.api.base_url'), '/');
        // Endpoint diisi oleh child class
        $this->endpoint = $this->getEndpoint();
    }

    /**
     * Child class wajib definisi endpoint-nya sendiri
     */
    abstract protected function getEndpoint(): string;

    public function all(): array
    {
        $response = Http::get("{$this->baseUrl}/{$this->endpoint}");
        return $this->handleResponse($response);
    }

    public function find(int $id): array
    {
        $response = Http::get("{$this->baseUrl}/{$this->endpoint}/{$id}");
        return $this->handleResponse($response);
    }

    public function create(array $data): array
    {
        $response = Http::post("{$this->baseUrl}/{$this->endpoint}", $data);
        return $this->handleResponse($response);
    }

    public function update(int $id, array $data): array
    {
        $response = Http::put("{$this->baseUrl}/{$this->endpoint}/{$id}", $data);
        return $this->handleResponse($response);
    }

    public function delete(int $id): bool
    {
        $response = Http::delete("{$this->baseUrl}/{$this->endpoint}/{$id}");
        return $response->successful();
    }

    /**
     * Helper: ekstrak 'data' dari response API kamu
     */
    protected function handleResponse($response): array
    {
        if (!$response->successful()) {
            Log::error('API Error', [
                'url' => $response->effectiveUri(),
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return [];
        }

        $json = $response->json();
        return $json['data'] ?? []; // ← sesuaikan dengan struktur API-mu
    }
}
