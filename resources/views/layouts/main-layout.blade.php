@props(['background' => ''])

@include('document.header')

<body>
    <main class="d-flex align-items-center justify-content-center {{ @$background }}">
        {{ @$slot }}

    </main>

    @yield('scripts')
</body>

</html>