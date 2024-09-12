<?php

require __DIR__ . '/vendor/autoload.php';

use App\Service\BinLookup\Api\BinListApi;
use App\Service\CurrencyExchange\Api\ExchangeRateApi;
use App\Service\Commission\Factory\CommissionFactory;
use App\Service\Commission\Handler\CommissionHandler;
use App\Model\TransactionModel;
use App\Logger\SimpleLogger;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$fileLoader = new \App\Service\File\FileLoader();
$fileData = $fileLoader->loadFile($argv[1]);
if (!$fileData) {
    throw new Exception('Failed retrieving data from file');
}

$logger = new SimpleLogger();
$binLookupApi = new BinListApi();
$exchangeRateApi = new ExchangeRateApi();
$comissionFactory = new CommissionFactory();
$comissionHandler = new CommissionHandler($binLookupApi, $exchangeRateApi, $comissionFactory);

foreach ($fileData as $row) {
    $transaction = new TransactionModel((int)$row['bin'], (float)$row['amount'], (string)$row['currency']);
    $commisionAmount = $comissionHandler->handle($transaction);
    if (!$commisionAmount) {
        $message = sprintf(
            'Error while processing transaction: bin-%s amount-%s currency-%s',
            $transaction->getBin(),
            $transaction->getAmount(),
            $transaction->getCurrency()
        );
        $logger->log($message);
    }
    echo $commisionAmount . PHP_EOL;
}
