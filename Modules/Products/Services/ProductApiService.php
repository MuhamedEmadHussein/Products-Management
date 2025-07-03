<?php

namespace Modules\Products\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class ProductApiService
{
    protected $client;
    protected $baseUri;

    public function __construct()
    {
        $this->baseUri = config('app.url') . '/api/v1/';
        $this->client = new Client([
            'base_uri' => $this->baseUri
        ]);
    }

    public function getCategories()
    {
        Log::info('Fetching all categories via API');
        try {
            $response = $this->client->get('categories');
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            Log::error('Error fetching categories: ' . $e->getMessage());
            throw new \Exception($this->extractErrorMessage($e));
        }
    }

    public function getCategory($id)
    {
        Log::info('Fetching category ID: ' . $id);
        try {
            $response = $this->client->get("categories/{$id}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            Log::error('Error fetching category: ' . $e->getMessage());
            throw new \Exception($this->extractErrorMessage($e), $e->getResponse()->getStatusCode());
        }
    }

    public function createCategory(array $data)
    {
        Log::info('Creating category via API', $data);
        try {
            $response = $this->client->post('categories', [
                'multipart' => $this->buildMultipartData($data),
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            Log::error('Error creating category: ' . $e->getMessage());
            throw new \Exception($this->extractErrorMessage($e), $e->getResponse()->getStatusCode());
        }
    }

    public function updateCategory($id, array $data)
    {
        Log::info('Updating category ID: ' . $id, $data);
        try {
            $response = $this->client->put("categories/{$id}", [
                'multipart' => $this->buildMultipartData($data),
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            Log::error('Error updating category: ' . $e->getMessage());
            throw new \Exception($this->extractErrorMessage($e), $e->getResponse()->getStatusCode());
        }
    }

    public function deleteCategory($id)
    {
        Log::info('Deleting category ID: ' . $id);
        try {
            $this->client->delete("categories/{$id}");
        } catch (RequestException $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            throw new \Exception($this->extractErrorMessage($e), $e->getResponse()->getStatusCode());
        }
    }

    public function getProducts($perPage = 10)
    {
        Log::info('Fetching all products via API');
        try {
            $response = $this->client->get('products', [
                'query' => ['per_page' => $perPage],
            ]);
            $data = json_decode($response->getBody()->getContents(), true);
            return new \Illuminate\Pagination\LengthAwarePaginator(
                collect($data['data']),
                $data['total'] ?? count($data),
                $data['per_page'] ?? $perPage,
                $data['current_page'] ?? 1,
                ['path' => url('products')]
            );
        } catch (RequestException $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            throw new \Exception($this->extractErrorMessage($e));
        }
    }

    public function getProduct($id)
    {
        Log::info('Fetching product ID: ' . $id);
        try {
            $response = $this->client->get("products/{$id}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            Log::error('Error fetching product: ' . $e->getMessage());
            throw new \Exception($this->extractErrorMessage($e), $e->getResponse()->getStatusCode());
        }
    }

    public function createProduct(array $data, $image = null)
    {
        Log::info('Creating product via API', $data);
        try {
            $multipart = $this->buildMultipartData($data);
            if ($image) {
                $multipart[] = [
                    'name' => 'image',
                    'contents' => fopen($image->getRealPath(), 'r'),
                    'filename' => time() . '.' . $image->getClientOriginalExtension(),
                ];
            }

            $response = $this->client->post('products', ['multipart' => $multipart]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            throw new \Exception($this->extractErrorMessage($e), $e->getResponse()->getStatusCode());
        }
    }

    public function updateProduct($id, array $data, $image = null)
    {
        Log::info('Updating product ID: ' . $id, $data);
        try {
            $multipart = $this->buildMultipartData($data);
            if ($image) {
                $multipart[] = [
                    'name' => 'image',
                    'contents' => fopen($image->getRealPath(), 'r'),
                    'filename' => time() . '.' . $image->getClientOriginalExtension(),
                ];
            }

            $response = $this->client->put("products/{$id}", ['multipart' => $multipart]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            throw new \Exception($this->extractErrorMessage($e), $e->getResponse()->getStatusCode());
        }
    }

    public function deleteProduct($id)
    {
        Log::info('Deleting product ID: ' . $id);
        try {
            $this->client->delete("products/{$id}");
        } catch (RequestException $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            throw new \Exception($this->extractErrorMessage($e), $e->getResponse()->getStatusCode());
        }
    }

    protected function buildMultipartData(array $data)
    {
        $multipart = [];
        foreach ($data as $key => $value) {
            if ($value !== null) {
                $multipart[] = [
                    'name' => $key,
                    'contents' => $value,
                ];
            }
        }
        return $multipart;
    }

    protected function extractErrorMessage(RequestException $e)
    {
        if ($e->hasResponse()) {
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);
            if (isset($response['errors'])) {
                $errors = [];
                foreach ($response['errors'] as $field => $messages) {
                    $errors[] = implode(', ', $messages);
                }
                return implode('; ', $errors);
            }
            return $response['error'] ?? $e->getMessage();
        }
        return $e->getMessage();
    }
}