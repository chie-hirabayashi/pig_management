<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;500&family=M+PLUS+Rounded+1c:wght@300;400;500&family=Zen+Maru+Gothic:wght@500&display=swap">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.0/css/all.css">

    <style>
        .MplusRound {
            font-family: 'M PLUS Rounded 1c', sans-serif;
        }

        .ZenMaruGothic {
            font-family: 'Zen Maru Gothic', sans-serif;
        }

        .table {
            counter-reset: rowCount;
        }

        .table>tbody>tr {
            counter-increment: rowCount;
        }

        .table>tbody>tr>th:first-child::before {
            content: "第"counter(rowCount)"位";
        }
    </style>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-white">
        {{-- <div class="min-h-screen bg-gray-100"> --}}
        {{-- <div class="max-h-96 bg-stone-300"> --}}
        {{-- <div class="min-h-full bg-stone-300"> --}}
        {{-- <div class="min-h-max bg-stone-300"> --}}
        {{-- <div class="min-h-fit bg-stone-300"> --}}
        @include('layouts.navigation')

        <!-- Page Heading -->
        {{-- <header class="bg-stone-200 shadow">
                <div class="font-semibold text-xl leading-tight text-gray-600 max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header> --}}

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    {{-- <div class="min-h-screen bg-stone-300">
        </div> --}}
</body>

</html>
