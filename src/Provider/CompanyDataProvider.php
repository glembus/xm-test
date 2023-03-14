<?php

namespace App\Provider;

use App\Client\DataHubApi\ApiClient;
use Symfony\Component\Cache\CacheItem;
use Symfony\Contracts\Cache\CacheInterface;

class CompanyDataProvider
{
    private const CACHE_COMPANY_KEY_PREFIX = 'company-';
    private const CACHE_COMPANIES_SYMBOLS_KEY = 'companies-symbols';

    public function __construct(private readonly ApiClient $client, private readonly CacheInterface $cache)
    {

    }

    /**
     * @return array<CompanyInterface>
     */
    public function getCompaniesSymbols(): array
    {
        $item = $this->cache->getItem(self::CACHE_COMPANIES_SYMBOLS_KEY);

        if (!$item->isHit()) {
            $companiesSymbols = $this->cacheCompanies();
            $item->set($companiesSymbols);

            return $companiesSymbols;
        }

        return $item->get();
    }

    public function getCompany(CompanyDataFilterInterface $filter): array
    {
        $item = $this->cache->getItem(self::CACHE_COMPANY_KEY_PREFIX.$filter->getSymbol());

        return $item->isHit() ? $item->get() : [];
    }

    private function cacheCompanies(): array
    {
        $item = new CacheItem();
        $companiesRawData = $this->client->getCompaniesData();
        $companiesSymbols = array_column($companiesRawData, 'Symbol');
        $tags = array_merge(
            [self::CACHE_COMPANY_KEY_PREFIX.'list'],
            array_map(function($key) {
                return self::CACHE_COMPANY_KEY_PREFIX.$key;
            }, $companiesSymbols)
        );
        $companiesSymbols = array_combine(array_values($companiesSymbols), $companiesRawData);
        $item->tag($tags);
        $item->set(array_combine(array_values($companiesSymbols), $companiesRawData));
        $item->expiresAt(new \DateTime('+12 hours'));
        $this->cache->save($item);

        return $companiesSymbols;
    }
}
