<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;


class InvoicesData
{
    private $rows;

    private $outputCurrency;

    private $currencyRates;

    private $vatNumber;

    public function __construct($input)
    {
        $this->outputCurrency = $input['outputCurrency'];
        $this->currencyRates = $input['currencyRates'];
        $this->vatNumber = $input['vatNumber'] ?? '';
    }

    public function setData($rows)
    {
        $this->rows = $rows;
    }

    public function calculate()
    {
        if ($this->vatNumber) {
            $this->rows = $this->rows->where('vat_number', $this->vatNumber);

            throw_if(
                $this->rows->isEmpty(),
                ValidationException::withMessages(['The Vat number does not exist'])
            );

            $company = $this->rows->first()['customer'];
        }

        $result = $this->rows->map(function ($row) {

            if ((int) $row['type'] !== 1) {
                throw_if(
                    empty($row['parent_document']) ||
                    $this->rows->where('document_number', '=', $row['parent_document'])->isEmpty(),
                    ValidationException::withMessages(['The parent number for document ' . $row['document_number'] . ' does not exist'])
                );
            }

            return $this->convert($row);
        });

        return [
            'total' => round($result->sum(), 2),
            'company' => $company ?? '',
            'outputCurrency' => $this->outputCurrency
        ];
    }

    private function convert($row)
    {
        $convertedValue = ($row['currency'] === $this->outputCurrency) ?
            (int) $row['total'] :
            $row['total'] * $this->currencyRates[$row['currency']] * $this->currencyRates[$this->outputCurrency];

        return ((int) $row['type'] === 2) ? (-1) * $convertedValue : $convertedValue;
    }


}
