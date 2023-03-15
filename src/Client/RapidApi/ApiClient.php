<?php

declare(strict_types=1);

namespace App\Client\RapidApi;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClient
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function getCompanyFinanceHistory(RapidApiFinanceFilterInterface $filter): array
    {
        $parameters['symbol'] = strtoupper($filter->getSymbol());
        $parameters['http_version'] = 1.1;
        if (null !== $filter->getRegion() && strlen($filter->getRegion()) > 0) {
            $parameters['region'] = $filter->getRegion();
        }

        try {
            $response = $this->client->request('GET', '/stock/v3/get-historical-data', ['query' => $parameters, 'http_version' => 1.1]);

            if ($response->getStatusCode() >= 400 || 'application/json' !== $response->getHeaders()['content-type'][0]) {
                throw new \Exception($response->getContent());
            }

            return $response->toArray();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), ['sContext' => $e->getTraceAsString()]);

            throw $e;
        }
    }
}
