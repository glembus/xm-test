<?php

declare(strict_types=1);

namespace App\Provider;

interface CompanyDataFilterInterface
{
    public function getSymbol(): string;
}
