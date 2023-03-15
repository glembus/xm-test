<?php

declare(strict_types=1);

namespace App\Provider;

use App\Client\RapidApi\RapidApiFinanceFilterInterface;

interface FinanceHistoryFilterInterface extends RapidApiFinanceFilterInterface
{
    public function getSymbol(): string;

    public function getStartDate(): \DateTimeInterface;

    public function getEndDate(): \DateTimeInterface;

    public function getRegion(): ?string;
}
