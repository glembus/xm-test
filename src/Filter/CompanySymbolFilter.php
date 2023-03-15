<?php

namespace App\Filter;

use App\Provider\CompanyDataFilterInterface;

class CompanySymbolFilter implements CompanyDataFilterInterface
{
    public function __construct(private readonly string $symbol)
    {
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
}
