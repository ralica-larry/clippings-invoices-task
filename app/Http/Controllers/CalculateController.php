<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateFormRequest;
use App\Imports\InvoicesDataImport;
use App\Services\InvoicesData;
use App\Services\ValidateDataImport;
use Maatwebsite\Excel\Facades\Excel;

class CalculateController extends Controller
{
    public function calculate(CalculateFormRequest $request)
    {
        $validated = $request->validated();

        $rows = Excel::toCollection(new InvoicesDataImport(), $validated['invoicesFile'])[0];

        ValidateDataImport::validate($rows);

        $invoicesData = new InvoicesData($validated);

        $invoicesData->setData($rows);

        return view('pages/results', [
            'results' => $invoicesData->calculate(),
        ]);
    }
}
