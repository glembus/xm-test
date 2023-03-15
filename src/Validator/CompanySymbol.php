<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class CompanySymbol extends Constraint
{
    public string $message = 'Company symbol: {{ companySymbol }} not valid';
    public string $mode = 'strict';

    public function getTargets(): array|string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
