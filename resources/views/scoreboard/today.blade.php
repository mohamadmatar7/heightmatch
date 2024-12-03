@section('title', 'Leaderboard Today')
<x-main-layout :background="'background'">
    <x-scoreboard :players="$players" :route="route('scoreboardAll')" :text="__('messages.all_time')" />
</x-main-layout>