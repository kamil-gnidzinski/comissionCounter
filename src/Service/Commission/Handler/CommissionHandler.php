<?php

namespace App\Service\Commission\Handler;

use App\Model\TransactionModel;
use App\Service\BinLookup\Api\BinLookupApiInterface;
use App\Service\Commission\Factory\CommissionFactoryInterface;
use App\Service\CurrencyExchange\Api\CurrencyExchangeApiInterface;

class CommissionHandler
{
    private BinLookupApiInterface $binLookupApi;
    private CurrencyExchangeApiInterface $currencyExchangeApi;
    private CommissionFactoryInterface $commissionFactory;

    public function __construct(
        BinLookupApiInterface        $binLookupApi,
        CurrencyExchangeApiInterface $currencyExchangeApi,
        CommissionFactoryInterface   $commissionFactory,
    )
    {
        $this->binLookupApi = $binLookupApi;
        $this->currencyExchangeApi = $currencyExchangeApi;
        $this->commissionFactory = $commissionFactory;
    }

    public function handle(TransactionModel $transaction): ?float
    {
        $country = $this->binLookupApi->getCountryByBin($transaction->getBin());
        $exchangeRate = $this->currencyExchangeApi->getRate($transaction->getAmount(), $transaction->getCurrency());
        if (!$country || !$exchangeRate) {
            return null;
        }
        $amountInEur = $transaction->getAmount() / $exchangeRate;
        $comission = $this->commissionFactory->create($amountInEur, $country);
        return $comission->calculate();
    }
}
