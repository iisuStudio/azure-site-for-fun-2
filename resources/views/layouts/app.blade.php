<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @auth
        <meta name="api-token" content="{{ auth()->user()->api_token }}">
        @endauth

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{asset('/css/app.css')}}" rel="stylesheet">

        <!-- Title -->
        <title>iisuStudio for Fun!</title>

        @include('google.gtm.head')

        @yield('page-css')
    </head>
    <body>
    @include('google.gtm.body')

    @include('layouts.header')

    <!--  網頁內容 -->
    <div id="app">

    @include('shared/navbar')

        <div class="container">

            @include('shared/alerts')

            @yield('content')

        </div>

    </div>

    <!-- Scripts -->
    <script src="{{asset('/js/app.js')}}"></script>

    @yield('page-js')

    </body>
</html>