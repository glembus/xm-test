<?php

namespace App\Validator;

use App\Provider\CompanyDataProvider;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CompanySymbolValidator extends ConstraintValidator
{
    public function __construct(private readonly CompanyDataProvider $companyDataProvider)
    {

    }

    public function validate(mixed $value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        $company = $this->companyDataProvider->getCompany($value);
        if (count($company) === 0) {
            throw new \UnexpectedValueException($value, 'string');
        }
    }
}
