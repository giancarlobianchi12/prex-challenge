<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GiphyService
{
    protected $apiKey;

    protected $client;

    public function __construct()
    {
        $this->apiKey = env('GIPHY_API_KEY');
        $this->client = new Client([
            'base_uri' => env('GIPHY_API_URL'),
            'timeout' => 20.0,
        ]);
    }

    public function searchGifs(string $query, int $limit = 20, int $offset = 0)
    {
        try {
            $response = $this->client->request('GET', 'v1/gifs/search', [
                'query' => [
                    'api_key' => $this->apiKey,
                    'q' => $query,
                    'limit' => $limit,
                    'offset' => $offset,
                ],
            ]);

            return $this->processResponse($response);
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    public function getGifById(string $id)
    {
        try {
            $response = $this->client->request('GET', "v1/gifs/{$id}", [
                'query' => [
                    'api_key' => $this->apiKey,
                ],
            ]);

            return $this->processResponse($response);
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    /**
     * Process sucessfull response
     *
     * @param [type] $response
     * @return void
     */
    private function processResponse($response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Process Exception
     *
     * @return void
     */
    private function handleRequestException(RequestException $e)
    {
        $statusCode = $e->getCode();

        if ($statusCode >= Response::HTTP_BAD_REQUEST && $statusCode < Response::HTTP_INTERNAL_SERVER_ERROR) {
            throw new HttpException($statusCode, 'Client error occurred.'); // to prevent expose internal api token
        } elseif ($statusCode >= Response::HTTP_INTERNAL_SERVER_ERROR) {
            throw new HttpException($statusCode, 'Server error.');
        } else {
            throw new \Exception('Unexpected error', $statusCode);
        }
    }
}
