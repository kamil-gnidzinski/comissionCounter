<?php

namespace App\Service\CurrencyExchange\Api;

interface CurrencyExchangeApiInterface
{
    public function getRate(float $amount, string $currency): ?float;
}