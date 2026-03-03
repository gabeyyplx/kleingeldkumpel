<?php

namespace App\Entity;

use App\Repository\RecurringTransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecurringTransactionRepository::class)]
class RecurringTransaction
{
    use TransactionTrait;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $lastApplied = null;

    #[ORM\Column]
    private ?int $frequencyInMonths = null;

    public function __construct() {
        $this->startDate = new \DateTimeImmutable()->modify('+1 day');
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getLastApplied(): ?\DateTimeImmutable
    {
        return $this->lastApplied;
    }

    public function setLastApplied(\DateTimeImmutable $lastApplied): static
    {
        $this->lastApplied = $lastApplied;

        return $this;
    }

    public function getFrequencyInMonths(): ?int
    {
        return $this->frequencyInMonths;
    }

    public function setFrequencyInMonths(int $frequencyInMonths): static
    {
        $this->frequencyInMonths = $frequencyInMonths;

        return $this;
    }

    public function getDueDates(): array
    {
        $today = new \DateTimeImmutable();
        $dates = [];

        $next = $this->lastApplied 
            ? $this->lastApplied->modify("+{$this->frequencyInMonths} months")
            : $this->startDate;

        while ($next <= $today) {
            $dates[] = $next;
            $next = $next->modify("+{$this->frequencyInMonths} months");
        }

        return $dates;
    }

    public function createTransaction(): Transaction 
    {
        return new Transaction()
            ->setValue($this->getValue())
            ->setIsIncome($this->isIncome())
            ->setName($this->getName())
            ->setUser($this->getUser())
            ->setDate(new \DateTimeImmutable())
            ->setCategory($this->getCategory());
    }
}
