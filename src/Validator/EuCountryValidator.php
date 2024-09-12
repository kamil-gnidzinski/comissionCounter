<?php

namespace App\Validator;

class EuCountryValidator implements CountryValidatorInterface
{
    private const EU_COUNTRIES = [
        'AT',
        'BE',
        'BG',
        'HR',
        'CY',
        'CZ',
        'DK',
        'EE',
        'FI',
        'FR',
        'DE',
        'GR',
        'HU',
        'IE',
        'IT',
        'LV',
        'LT',
        'LU',
        'MT',
        'NL',
        'PL',
        'PT',
        'RO',
        'SK',
        'SI',
        'ES',
        'SE'
    ];

    public function validate(string $countryCode): bool
    {
        return in_array(strtoupper($countryCode), self::EU_COUNTRIES);
    }
}