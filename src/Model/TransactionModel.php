<?php

namespace App\Model;

class TransactionModel
{
    private int $bin;
    private float $amount;
    private string $currency;

    public function __construct(int $bin, float $amount, string $currency)
    {
        $this->bin = $bin;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getBin(): int
    {
        return $this->bin;
    }

    public function setBin(int $bin): self
    {
        $this->bin = $bin;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }
}
