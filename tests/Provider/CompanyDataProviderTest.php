<?php

declare(strict_types=1);

namespace App\Tests\Provider;

use App\Client\DataHubApi\ApiClient;
use App\Filter\CompanyDataFilter;
use App\Provider\CompanyDataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;

class CompanyDataProviderTest extends TestCase
{
    private ApiClient $apiClient;

    private TagAwareAdapterInterface $cacheInterface;

    public function setUp(): void
    {
        $this->apiClient = $this->createMock(ApiClient::class);
        $this->cacheInterface = $this->createMock(TagAwareAdapterInterface::class);
    }

    /**
     * @s
     *
     * @dataProvider getCompanyData
     */
    public function testGetCompany(int $expectPositiveCalls, int $expectNegativeCals, string $symbol, array $companyData): void
    {
        $this->markTestSkipped('Currently TagAwareAdapterInterface getItem method declared to return CacheItem instead '
        . 'of CacheItemInterface. See: https://github.com/symfony/symfony/issues/45113');

        $filter = $this->createMock(CompanyDataFilter::class);
        $filter->expects(self::exactly($expectPositiveCalls))->method('getSymbol')->willReturn($symbol);
        $cacheItem = $this->createMock(CacheItemInterface::class);
        $cacheItem->expects(self::exactly($expectNegativeCals))->method('isHit')->willReturn(false);
        $cacheItem->expects(self::exactly($expectNegativeCals))->method('set')->willReturn($cacheItem);
        $cacheItem->expects(self::exactly($expectNegativeCals))->method('expiresAt')->willReturn($cacheItem);
        if ($expectPositiveCalls !== $expectNegativeCals) {
            $cacheItem->expects(self::exactly($expectPositiveCalls))->method('get')->willReturn($companyData);
        }
        $this->cacheInterface->expects(self::exactly($expectPositiveCalls))->method('getItem')->willReturn($cacheItem);
        $this->cacheInterface->expects(self::exactly($expectPositiveCalls))->method('save')->willReturn(true);
        $this->apiClient->expects(self::exactly($expectPositiveCalls))->method('getCompaniesData')->willReturn($companyData);

        $dataProvider = new CompanyDataProvider($this->apiClient, $this->cacheInterface);
        $dataProvider->getCompany($filter);
    }

    public function getCompanyData(): array
    {
        return [
            [1, 1, 'TEST_SYMBOL', [['Symbol' => 'SYMBOL', 'Company Name' => 'Name']]],
            [1, 0, 'TEST_SYMBOL', [['Symbol' => 'TEST_SYMBOL', 'Company Name' => 'Name']]],
        ];
    }
}
