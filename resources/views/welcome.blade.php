<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.welcome') }}</title>
</head>

<body>

    <div class="container">
        <h1>{{ __('messages.welcome') }}</h1>

        <!-- Language Switcher -->
        <div class="language-selector">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $localeName)
            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                {{ $localeName['native'] }}
            </a> |
            @endforeach
        </div>

        <p>{{ __('messages.nickname_label') }}</p>
        <p>{{ __('messages.age_label') }}</p>

        <!-- Other content -->

    </div>

</body>

</html>