@extends('layouts.app')

@push('page-styles')
    <style>

    </style>
@endpush

@section('content')
    <p class="text-center text-3xl">Invoices calculation</p>

    @if ($errors->any())
        <div
                class="flex flex-col pt-3 md:pt-8" role="alert"
        >
            <div class="text-red-800">
                <h4 class="text-lg">Errors occurred</h4>
                <hr class="pb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <form method="post" action="/" enctype="multipart/form-data" class="flex flex-col pt-3 md:pt-8">

        @csrf

        <div class="flex flex-col pt-4">
            <label for="invoicesFile" class="text-lg">Invoices data file <span class="text-red-800">*</span> </label>

            <label class="flex flex-col w-full h-32 border-2 border-sky-200 border-dashed rounded hover:bg-gray-100 hover:border-gray-300 cursor-pointer">
                <div class="flex flex-col items-center justify-center pt-7">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 group-hover:text-gray-600"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">
                        Attach a file
                    </p>
                </div>
                <input
                        type="file"
                        name="invoicesFile"
                        id="invoicesFile"
                        value="{{ old('invoicesFile') }}"
                        class="opacity-0"
                />
            </label>
        </div>

        <div class="flex flex-col pt-4">
            <label for="currencyRates" class="text-lg">Currency rates <span class="text-red-800">*</span> </label>
            <input
                    type="text"
                    name="currencyRates"
                    id="currencyRates"
                    value="{{ old('currencyRates') }}"
                    placeholder="EUR:1, USD:0.987 , GBP:0.878"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline"
            >
        </div>

        <div class="flex flex-col pt-4">
            <label for="outputCurrency" class="text-lg">Output currency <span class="text-red-800">*</span> </label>
            <input
                    type="text"
                    name="outputCurrency"
                    id="outputCurrency"
                    value="{{ old('outputCurrency') }}"
                    placeholder="EUR"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline"
            />
        </div>

        <div class="flex flex-col pt-4">
            <label for="vatNumber" class="text-lg">Customer VAT Number </label>
            <input
                    type="text"
                    name="vatNumber"
                    id="vatNumber"
                    value="{{ old('vatNumber') }}"
                    placeholder="123456789"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline"
            />
        </div>

        <div class="flex items-center justify-center w-full">

        </div>

        <input
                type="submit"
                value="Calculate"
                class="bg-sky-700 text-white font-bold text-lg hover:bg-red-800 p-2 mt-8 cursor-pointer"
        />
    </form>
@endsection
