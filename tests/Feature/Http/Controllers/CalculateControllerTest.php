<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;


class CalculateControllerTest extends TestCase
{
    public function test_success_without_filter()
    {
        $response = $this->withHeaders(['CONTENT_TYPE' => 'multipart/form-data'])
            ->post('/', [
            'currencyRates' => 'EUR:1, USD:0.987 , GBP:0.878',
            'outputCurrency' => 'GBP',
            'invoicesFile' => $this->getFile(),
        ]);

        $response->assertViewIs('pages.results');
        $response->assertSee('3718.32');
    }

    public function test_success_with_filter()
    {
        $response = $this->withHeaders(['CONTENT_TYPE' => 'multipart/form-data'])
            ->post('/', [
                'currencyRates' => 'EUR:1, USD:0.987 , GBP:0.878',
                'outputCurrency' => 'GBP',
                'vatNumber' => '123456789',
                'invoicesFile' => $this->getFile(),
            ]);

        $response->assertViewIs('pages.results');
        $response->assertSee('1713.63');
        $response->assertSee('Vendor 1');
    }


    public function test_non_valid_currency_rates()
    {
        $response = $this->withHeaders(['CONTENT_TYPE' => 'multipart/form-data'])
            ->post('/', [
                'currencyRates' => 'not valid',
                'outputCurrency' => 'GBP',
                'vatNumber' => '123456789',
                'invoicesFile' => $this->getFile(),
            ])
        ->assertStatus(302);

        $this->assertEquals($response->exception->status, 422);
    }

    private function getFile()
    {
        return UploadedFile::fake()->createWithContent(
            'data.csv',
            "Customer,Vat number,Document number,Type,Parent document,Currency,Total
Vendor 1,123456789,1000000257,1,,USD,400
Vendor 2,987654321,1000000258,1,,EUR,900
Vendor 3,123465123,1000000259,1,,GBP,1300
Vendor 1,123456789,1000000260,2,1000000257,EUR,100
Vendor 1,123456789,1000000261,3,1000000257,GBP,50
Vendor 2,987654321,1000000262,2,1000000258,USD,200
Vendor 3,123465123,1000000263,3,1000000259,EUR,100
Vendor 1,123456789,1000000264,1,,EUR,1600");
    }
}
