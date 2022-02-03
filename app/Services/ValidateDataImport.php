<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class ValidateDataImport
{
    public static function validate(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            Validator::make($row->toArray(), [
                'customer'        => ['required', 'string'],
                'vat_number'      => ['required', 'string'],
                'document_number' => ['required', 'string'],
                'type'            => ['required', 'numeric', 'max:3'],
                'parent_document' => ['sometimes', 'nullable', 'string'],
                'currency'        => ['required', 'string', 'size:3'],
                'total'           => ['required', 'numeric'],
            ],
            [
                '*.required' => 'Line ' . ($key + 2) . ': :attribute is required',
                '*.string' => 'Line ' . ($key + 2) . ': :attribute should be string',
                '*.numeric' => 'Line ' . ($key + 2) . ': :attribute should be numeric',
                '*.size' => 'Line ' . ($key + 2) . ': :attribute should have :size characters',
                '*.max' => 'Line ' . ($key + 2) . ': :attribute should be less or equal to :max',
            ])->validate();
        }
    }
}
