<?php

namespace App\Provider;

use App\Client\RapidApi\ApiClient;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class FinanceHistoryDataProvider
{
    private const CACHE_FINANCE_HISTORY_PREFIX_KEY = 'finance-history-';

    public function __construct(private readonly ApiClient $client, private readonly RedisAdapter $cache)
    {

    }

    public function getCompanyFinancialHistory(FinanceHistoryFilterInterface $filter): array
    {
        $item = $this->cache->getItem(self::CACHE_FINANCE_HISTORY_PREFIX_KEY.$filter->getSymbol());
        if (!$item->isHit()) {
            $financialData = $this->client->getCompanyFinanceHistory($filter);
            $item->set($financialData);
            $item->expiresAt(''); //TODO do not forget to add offset from API to expire At time
            $this->cache->save($item);
        }

        $start = $filter->getStartDate()->getTimestamp();
        $end = $filter->getEndDate()->getTimestamp();
        $financialData = $item->get();

        return array_filter($financialData, function ($item) use ($start, $end) {
            $date = $item['date'];

            return $date >= $start && $date <= $end;
        });
    }
}
