<?php

namespace App\Service\Commission;

use App\Service\Rate\RateInterface;

class Commission
{
    private float $amount;
    private RateInterface $rate;

    public function __construct(float $amount, RateInterface $rate)
    {
        $this->amount = $amount;
        $this->rate = $rate;
    }

    public function calculate(): float
    {
        $commisionAmount = $this->amount * $this->rate->getRate();
        return ceil(($commisionAmount) * 100) / 100;
    }
}
