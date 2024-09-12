<?php

namespace App\Service\Commission;

use App\Service\Rate\BaseRate;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(\App\Service\Commission\Commission::class)]
class CommissionTest extends TestCase
{
    #[dataProvider('calculateDataProvider')]
    public function testCalculate(float $amount, float $rateValue, float $expectedValue)
    {
        $rateMock = $this->createMock(BaseRate::class);
        $rateMock->expects($this->once())->method('getRate')->willReturn($rateValue);
        $comission = new Commission($amount, $rateMock);
        $this->assertEquals($expectedValue, $comission->calculate());
    }

    public static function calculateDataProvider(): array
    {
        return [
            [100, 0.1, 10.0],
            [42, 0.2, 8.4],
            [1432.46, 0.3, 429.74],
        ];
    }
}