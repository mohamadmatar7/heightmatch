<x-main-layout :background="'background'">
    <div class="container py-5 d-flex flex-column align-items-center justify-content-center rounded shadow"
        style="background-color: rgba(255, 255, 255, 0.7); backdrop-filter: blur(16x);">
        <!-- Language Selector Section -->
        <div class=" text-center mb-5">
            <h1 class="mb-4 text-success display-4">{{ __('messages.Choose Your Language') }}</h1>
            <div class="btn-group" role="group" aria-label="Language Selector">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $localeName)
                <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                    class="btn btn-lg btn-outline-success {{ app()->getLocale() === $localeCode ? 'active' : '' }} mx-2">
                    {{ $localeName['native'] }}
                </a>
                @endforeach
            </div>
        </div>

        <!-- Welcome Section -->
        <div class="text-center px-4">
            <h1 class="mb-4 text-success display-4">{{ __('messages.welcome to') }} {{ config('app.name') }}</h1>
            <p class="lead  mb-4">
                <span class="fw-bold">{{ config('app.name') }}</span>
                {{ __('messages.measures the jump height of GUM Museum visitors, offering an engaging and accurate experience using advanced sensor technology.') }}
            </p>
            <a href=" {{ route('playerInput') }}" class="btn btn-success btn-lg px-5">
                {{ __('messages.start') }}
            </a>
        </div>
    </div>
</x-main-layout>