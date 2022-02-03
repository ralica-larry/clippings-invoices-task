@extends('layouts.app')

@push('page-styles')
    <style>

    </style>
@endpush

@section('content')
    <p class="text-center text-3xl pb-12">Results</p>
    <h2 class="flex justify-center text-3xl text-sky-800 pb-12">
        @if(! empty($results['company']))
            <span> &nbsp; Company <b> {{ $results['company'] }} </b>  -  &nbsp;</span>
        @endif
        Total: {{ $results['total'] }} {{$results['outputCurrency']}}
    </h2>
    <a class="flex justify-end" href="{{ route('home') }}" >Go back </a>
@endsection
