<?php

namespace App\Service\BinLookup\Api;

interface BinLookupApiInterface
{
    public function getCountryByBin(int $binNumber): ?string;
}