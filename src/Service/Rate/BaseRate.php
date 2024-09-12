<?php

namespace App\Service\Rate;

class BaseRate implements RateInterface
{
    public function getRate(): float
    {
        return 0.02;
    }
}