<?php

declare(strict_types=1);

namespace App\Provider;

use App\Client\RapidApi\ApiClient;
use Symfony\Contracts\Cache\CacheInterface;

class FinanceHistoryDataProvider
{
    private const CACHE_FINANCE_HISTORY_PREFIX_KEY = 'finance-history-';

    public function __construct(private readonly ApiClient $client, private readonly CacheInterface $cache)
    {
    }

    public function getCompanyFinancialHistory(FinanceHistoryFilterInterface $filter): array
    {
        $item = $this->cache->getItem(self::CACHE_FINANCE_HISTORY_PREFIX_KEY.$filter->getSymbol());
        if (!$item->isHit()) {
            $financialData = $this->client->getCompanyFinanceHistory($filter);
            $item->set($financialData);
            $item->expiresAt(new \DateTime('+1 hours'));
            $this->cache->save($item);
        }

        $start = $filter->getStartDate()->getTimestamp();
        $end = $filter->getEndDate()->getTimestamp();
        $financialData = $item->get();
        $prices = $financialData['prices'];
        unset($financialData['prices']);
        $financialData['prices'] = array_filter($prices, function ($item) use ($start, $end) {
            $date = $item['date'];

            return $date >= $start && $date <= $end;
        });

        return $financialData;
    }
}
