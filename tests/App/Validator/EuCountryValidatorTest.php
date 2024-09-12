<?php

namespace App\Validator;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(\App\Validator\EuCountryValidator::class)]
class EuCountryValidatorTest extends TestCase
{
    #[DataProvider('validateDataProvider')]
    public function testValidate(string $countryCode, bool $expectedValue)
    {
        $countryValidator = new EuCountryValidator();
        $this->assertEquals($expectedValue, $countryValidator->validate($countryCode));
    }

    public static function validateDataProvider(): array
    {
        return [
            ['PL', true],
            ['GB', false],
            ['US', false],
            ['INVALID_CODE', false],
        ];
    }
}