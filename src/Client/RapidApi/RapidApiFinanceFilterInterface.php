<?php

namespace App\Client\RapidApi;

interface RapidApiFinanceFilterInterface
{
    public function getSymbol(): string;

    public function getRegion(): ?string;
}
