<?php

declare(strict_types=1);

namespace App\Client\RapidApi;

interface RapidApiFinanceFilterInterface
{
    public function getSymbol(): string;

    public function getRegion(): ?string;
}
