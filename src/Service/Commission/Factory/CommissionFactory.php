<?php


namespace App\Service\Commission\Factory;

use App\Service\Commission\Commission;
use App\Service\Rate\BaseRate;
use App\Service\Rate\EuRate;
use App\Validator\EuCountryValidator;

class CommissionFactory implements CommissionFactoryInterface
{
    public function create(float $amount, string $countryCode): Commission
    {
        $isEu = (new EuCountryValidator())->validate($countryCode);
        $rate = $isEu ? new EuRate() : new BaseRate();
        return new Commission($amount, $rate);
    }
}
