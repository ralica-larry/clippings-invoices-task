<?php

namespace App\Services;

class CurrencyRates
{
    private $rates;

    public function __construct($input)
    {
        $this->rates = $input;
    }

    public function convert($row, $outputCurrency)
    {
        return $row->total * $this->rates[$row->currency] * $this->rates[$outputCurrency];
    }


}
