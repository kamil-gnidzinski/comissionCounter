<?php

namespace App\Service\Api;

use App\Logger\LoggerInterface;
use App\Logger\SimpleLogger;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

abstract class ApiConnector
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger ?? new SimpleLogger();
    }


    protected function call(string $uri, string $endpoint, string $method, array $options = []): array
    {
        try {
            $client = new Client([
                'base_uri' => $uri,
                'timeout' => 6.0
            ]);

            $response = $client->request($method, $endpoint, $options);

            return json_decode($response->getBody()->getContents(), true);

        } catch (RequestException $e) {
            $this->logger->log('Request failed: ' . $e->getMessage());
        }

        return [];
    }
}