<?php

namespace App\Client\RapidApi;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ApiClient
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly LoggerInterface $logger,
    ) {

    }

    public function getCompanyFinanceHistory(RapidApiFinanceFilterInterface $filter): array
    {
        $parameters['symbol'] = strtoupper($filter->getSymbol());
        if (null !== $filter->getRegion() && strlen($filter->getRegion()) > 0) {
            $parameters['region'] = $filter->getRegion();
        }

        try {
            $response = $this->client->request('GET', '/stock/v3/get-historical-data', ['query' => $parameters]);

            if ($response->getStatusCode() >= 400 || $response->getHeaders()['content-type'][0] !== 'application/json') {
                throw new \Exception($response->getContent());
            }

            return $response->toArray();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), ['sContext' => $e->getTraceAsString()]);

            throw $e;
        }
    }
}
