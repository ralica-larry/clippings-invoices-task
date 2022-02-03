<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices</title>
    <meta name="description" content="">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

        .font-family-karla {
            font-family: karla;
        }
    </style>
    @stack('page-styles')
</head>
<body class="bg-white font-family-karla h-screen">

<div class="w-full flex flex-wrap">

    <!-- Image Section -->
    <div class="w-1/3 shadow-2xl">
        <img class="object-cover w-full h-screen hidden md:block" src="{{ asset('images/unsplash.jpg') }}">
    </div>

    <!-- Login Section -->
    <div class="w-full md:w-2/3 flex flex-col justify-center">
        <div class="flex flex-col justify-center md:justify-start my-auto pt-8 md:pt-0 px-8 md:px-24 lg:px-32">
            @yield('content', 'No such page!')
        </div>

    </div>


</div>

</body>
</html>
