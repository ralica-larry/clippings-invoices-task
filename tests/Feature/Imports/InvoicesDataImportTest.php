<?php

namespace Tests\Feature\Imports;

use App\Imports\InvoicesDataImport;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;


class InvoicesDataImportTest extends TestCase
{
    public function test_successful_import()
    {
        $dataImport = new InvoicesDataImport();

        $rows = Excel::toCollection($dataImport, $this->getGoodFile())[0];

        $dataImport->collection($rows);

        $this->assertEquals(3, $rows->count());
    }

    public function test_failed_import()
    {
        $response = $this->withHeaders(['CONTENT_TYPE' => 'multipart/form-data'])
            ->post('/', [
                'currencyRates' => 'EUR:1, USD:0.987 , GBP:0.878',
                'outputCurrency' => 'GBP',
                'invoicesFile' => $this->getBadFile(),
            ])
            ->assertStatus(302);

        $this->assertEquals($response->exception->status, 422);
    }

    private function getGoodFile()
    {
        return UploadedFile::fake()->createWithContent(
            'data.csv',
            "Customer,Vat number,Document number,Type,Parent document,Currency,Total
Vendor 1,123456789,1000000257,1,,USD,400
Vendor 2,987654321,1000000258,1,,EUR,900
Vendor 3,123465123,1000000259,1,,GBP,1300"
        );
    }

    private function getBadFile()
    {
        return UploadedFile::fake()->createWithContent(
            'data.csv',
            "Customer,Vat number,Document number,Type,Parent document,Currency,Total
Vendor 1,,1000000257,1,,USD,400
Vendor 2,987654321,1000000258,1,,EUR,900
Vendor 3,123465123,1000000259,1,,GBP,1300");
    }

}
