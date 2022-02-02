<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateFormRequest;

use App\Imports\InvoicesDataImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use PHPUnit\Exception;

use function current;


class CalculateController extends Controller
{
    public function calculate(CalculateFormRequest $request)
    {
        $validated = $request->validated();

        $rows = Excel::toCollection(new InvoicesDataImport(), $validated['invoicesFile'])[0];

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
                '*.required' => 'Line ' . ($key + 1) . ': :attribute is required',
                '*.string' => 'Line ' . ($key + 1) . ': :attribute should be string',
                '*.numeric' => 'Line ' . ($key + 1) . ': :attribute should be numeric',
                '*.size' => 'Line ' . ($key + 1) . ': :attribute should have 3 characters',
                '*.max' => 'Line ' . ($key + 1) . ': :attribute should be 1, 2 or 3',
            ])->validate();
        }
/** If we do not need lines */
//        Validator::make($rows->toArray(), [
//            'customer'        => ['required', 'string'],
//            'vat_number'      => ['required', 'string'],
//            'document_number' => ['required', 'string'],
//            'type'            => ['required', 'numeric', 'max:3'],
//            'parent_document' => ['sometimes', 'nullable', 'string'],
//            'currency'        => ['required', 'string', 'max:3'],
//            'total'           => ['required', 'numeric'],
//        ])->validate();

        return view('results', [
            'results' => $validated['outputCurrency'],
        ]);
    }
}
