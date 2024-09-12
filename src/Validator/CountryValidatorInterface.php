<?php

namespace App\Validator;

interface CountryValidatorInterface
{
    public function validate(string $countryCode): bool;
}