<?php

namespace App\Service\BinLookup\Api;

use App\Logger\LoggerInterface;
use App\Service\Api\ApiConnector;

class BinListApi extends ApiConnector implements BinLookupApiInterface
{
    private const URL = 'https://lookup.binlist.net/';

    public function __construct(LoggerInterface $logger = null)
    {
        parent::__construct($logger);
    }

    public function getCountryByBin(int $binNumber): ?string
    {
        $response = $this->call(self::URL, $binNumber, 'GET');
        return $response ? $response['country']['alpha2'] : null;
    }
}
