<?php

namespace App\Filter;

use App\Provider\CompanyDataFilterInterface;
use App\Provider\FinanceHistoryFilterInterface;
use App\Validator\CompanySymbol;
use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Expression("this.getStartDate() < this.getEndDate()", message: 'Start period date should be early then end period date!')]
class CompanyDataFilterRapid implements FinanceHistoryFilterInterface, CompanyDataFilterInterface
{
    #[Assert\NotBlank]
    #[CompanySymbol]
    private string $symbol;

    #[Assert\NotBlank]
    #[Assert\Date]
    private \DateTimeInterface $startDate;

    #[Assert\NotBlank]
    #[Assert\Date]
    private \DateTimeInterface $endDate;

    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    private ?string $region;

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): \DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }
}
