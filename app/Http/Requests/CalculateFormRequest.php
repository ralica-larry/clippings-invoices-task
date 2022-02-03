<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class CalculateFormRequest extends FormRequest
{
    public function validated(): array
    {
        $validated = $this->validator->validated();

        $merged = collect($validated);

        if ($this->filled('currencyRates')) {

            $rates = [];

            $input = explode(',', str_replace(' ', '', $validated['currencyRates']));

            foreach ($input as $currency) {
                $tempCurrency = explode(':', $currency);
                $rates[$tempCurrency[0]] = $tempCurrency[1];
            }

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
