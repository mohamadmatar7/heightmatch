<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>@yield('title', config('app.name'))</title>

    <!-- favicon -->
    @include('document.favicon')

    <!-- Fonts -->
    @include('document.fonts')

    <!-- Styles -->
    @include('document.styles')

    <!-- Scripts -->
    @include('document.scripts')
</head>