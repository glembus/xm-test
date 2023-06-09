<?php

declare(strict_types=1);

namespace App\Client\DataHubApi;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClient
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function getCompaniesData(): array
    {
        try {
            $response = $this->client->request(
                'GET',
                '/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json'
            );

            if ($response->getStatusCode() >= 400) {
                throw new \Exception($response->getContent(false));
            }

            return $response->toArray();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), ['sContext' => $e->getTraceAsString()]);

            throw $e;
        }
    }
}
