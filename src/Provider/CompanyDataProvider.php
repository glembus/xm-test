<?php

namespace App\Provider;

use App\Client\DataHubApi\ApiClient;
use Psr\Cache\CacheItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class CompanyDataProvider
{
    private const CACHE_COMPANY_KEY_PREFIX = 'company-';

    public function __construct(private readonly ApiClient $client, private readonly TagAwareCacheInterface $cache)
    {
    }

    /**
     * @return array<CompanyInterface>
     */
    public function getCompaniesSymbols(): array
    {
        $item = $this->cache->getItem(self::CACHE_COMPANY_KEY_PREFIX.'list');

        if (!$item->isHit()) {
            return $this->cacheCompanies($item);
        }

        return $item->get();
    }

    public function getCompany(CompanyDataFilterInterface $filter): array
    {
        $item = $this->cache->getItem(self::CACHE_COMPANY_KEY_PREFIX.'list');

        if (!$item->isHit()) {
            $companiesData = $this->getCompaniesSymbols();
        } else {
            $companiesData = $item->get();
        }

        return $companiesData[$filter->getSymbol()] ?? [];
    }

    private function cacheCompanies(CacheItemInterface $item): array
    {
        $companiesRawData = $this->client->getCompaniesData();
        $companiesSymbols = array_column($companiesRawData, 'Symbol');
        $companiesSymbols = array_combine(array_values($companiesSymbols), $companiesRawData);
        $item->set($companiesSymbols);
        $item->expiresAt(new \DateTime('+1 hours'));
        $this->cache->save($item);
        $this->cache->commit();

        return $companiesSymbols;
    }
}
