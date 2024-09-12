<?php

namespace App\Service\Commission\Handler;

use App\Model\TransactionModel;
use App\Service\BinLookup\Api\BinListApi;
use App\Service\Commission\Factory\CommissionFactory;
use App\Service\CurrencyExchange\Api\ExchangeRateApi;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;


#[CoversClass(\App\Service\Commission\Handler\CommissionHandler::class)]
class CommissionHandlerTest extends TestCase
{
    private $binLookupApiMock;
    private $currencyExchangeApiMock;
    private $commissionFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->binLookupApiMock = $this->createMock(BinListApi::class);
        $this->currencyExchangeApiMock = $this->createMock(ExchangeRateApi::class);
        $this->commissionFactory = new CommissionFactory();
    }

    public function testHandle()
    {
        $binLookupApiMock = $this->binLookupApiMock;
        $binLookupApiMock
            ->expects($this->once())
            ->method('getCountryByBin')
            ->with(123)
            ->willReturn('PL');

        $currencyExchangeApiMock = $this->currencyExchangeApiMock;
        $currencyExchangeApiMock
            ->expects($this->once())
            ->method('getRate')
            ->with(10.0, 'FOO')
            ->willReturn(2.0);

        $transactionModel = new TransactionModel(123, 10.0, 'FOO');

        $handler = new CommissionHandler($binLookupApiMock, $currencyExchangeApiMock, $this->commissionFactory);
        $this->assertEquals(0.05, $handler->handle($transactionModel));
    }

    public function testHandleBinApiFailure()
    {
        $binLookupApiMock = $this->binLookupApiMock;
        $binLookupApiMock
            ->expects($this->once())
            ->method('getCountryByBin')
            ->with(123)
            ->willReturn(null);

        $currencyExchangeApiMock = $this->currencyExchangeApiMock;
        $currencyExchangeApiMock
            ->expects($this->once())
            ->method('getRate')
            ->with(10.0, 'FOO')
            ->willReturn(2.0);

        $transactionModel = new TransactionModel(123, 10.0, 'FOO');

        $handler = new CommissionHandler($binLookupApiMock, $currencyExchangeApiMock, $this->commissionFactory);
        $this->assertEquals(null, $handler->handle($transactionModel));
    }

    public function testHandleCurrencyApiFailure()
    {
        $binLookupApiMock = $this->binLookupApiMock;
        $binLookupApiMock
            ->expects($this->once())
            ->method('getCountryByBin')
            ->with(123)
            ->willReturn('PL');

        $currencyExchangeApiMock = $this->currencyExchangeApiMock;
        $currencyExchangeApiMock
            ->expects($this->once())
            ->method('getRate')
            ->with(10.0, 'FOO')
            ->willReturn(null);

        $transactionModel = new TransactionModel(123, 10.0, 'FOO');

        $handler = new CommissionHandler($binLookupApiMock, $currencyExchangeApiMock, $this->commissionFactory);
        $this->assertEquals(null, $handler->handle($transactionModel));
    }
}