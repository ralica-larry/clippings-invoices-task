<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;


class CalculateFormRequest extends FormRequest
{
    public function validated(): array
    {
        $validated = $this->validator->validated();

        $merged = collect($validated);

        if ($this->filled('currencyRates')) {

            $rates = [];

            $input = explode(',', str_replace(' ', '', $validated['currencyRates']));

            try {
                foreach ($input as $currency) {
                    $tempCurrency = explode(':', $currency);
                    $rates[$tempCurrency[0]] = $tempCurrency[1];
                }
            } catch (Exception $exception) {
                throw ValidationException::withMessages(['Currency rates not in valid format']);
            }

            throw_unless(
                isset($rates[$validated['outputCurrency']]),
                ValidationException::withMessages(['Output currency do not have a rate'])
            );

            $merged->put(
                'currencyRates',
                $rates
            );
        }

        return $merged->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'currencyRates' => [
                'required',
                'string',
            ],
            'outputCurrency' => [
                'required',
                'string',
            ],
            'vatNumber' => [
                'sometimes',
                'nullable',
                'string',
            ],
            'invoicesFile' => [
                'required',
                'file',
                'mimes:csv'
            ],
        ];
    }
}
