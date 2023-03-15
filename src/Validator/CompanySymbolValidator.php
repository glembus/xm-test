<?php

declare(strict_types=1);

namespace App\Validator;

use App\Filter\CompanySymbolFilter;
use App\Provider\CompanyDataProvider;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class CompanySymbolValidator extends ConstraintValidator
{
    public function __construct(private readonly CompanyDataProvider $companyDataProvider)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        $company = $this->companyDataProvider->getCompany(new CompanySymbolFilter($value));
        if (0 === count($company)) {
            throw new InvalidArgumentException('Company with symbol: '.$value.' not existed');
        }
    }
}
