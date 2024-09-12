<?php

namespace App\Service\Rate;

class EuRate implements RateInterface
{
    public function getRate(): float
    {
        return 0.01;
    }
}