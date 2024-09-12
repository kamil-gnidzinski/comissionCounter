<?php

namespace App\Service\Commission\Factory;

use App\Service\Commission\Commission;

interface CommissionFactoryInterface
{
    public function create(float $amount, string $countryCode): Commission;
}
