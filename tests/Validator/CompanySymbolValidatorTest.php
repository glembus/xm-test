<?php

declare(strict_types=1);

namespace App\Tests\Validator;

use App\Provider\CompanyDataProvider;
use App\Validator\CompanySymbolValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class CompanySymbolValidatorTest extends TestCase
{
    /** @dataProvider data */
    public function testValidate(string $symbol, array $company, int $expectCall): void
    {
        $dataProvider = $this->createMock(CompanyDataProvider::class);
        $dataProvider->expects(self::exactly($expectCall))->method('getCompany')->willReturn($company);
        $constrain = $this->createMock(Constraint::class);

        $validator = new CompanySymbolValidator($dataProvider);
        if ('FAIL' === $symbol) {
            $this->expectExceptionObject(new InvalidArgumentException('Company with symbol: '.$symbol.' not existed'));
        }

        $validator->validate($symbol, $constrain);
    }

    public function data(): array
    {
        return [
            ['', [], 0],
            ['FAIL', [], 1],
            ['SUCCESS', ['some company'], 1],
        ];
    }
}
