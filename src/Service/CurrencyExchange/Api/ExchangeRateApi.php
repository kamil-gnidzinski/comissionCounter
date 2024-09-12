<?php

namespace App\Service\CurrencyExchange\Api;

use App\Logger\LoggerInterface;
use App\Service\Api\ApiConnector;

class ExchangeRateApi extends ApiConnector implements CurrencyExchangeApiInterface
{
    private const URL = 'https://api.exchangeratesapi.io/';
    private string $accessKey;

    public function __construct(LoggerInterface $logger = null)
    {
        parent::__construct($logger);
        $this->accessKey = $_ENV['EXCHANGE_RATE_API_ACCESS_KEY'];
    }

    public function getRate(float $amount, string $currency): ?float
    {
        $endpoint = sprintf('latest?access_key=%s', $this->accessKey);
        $response = $this->call(self::URL, $endpoint, 'GET');
        return $response ? $response['rates'][$currency] : null;
    }
}
