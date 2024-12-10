@section('title', 'Leaderboard Today')
<x-main-layout :background="'background'">
    <x-scoreboard :players="$players" :headerText="__('messages.today')" :route="route('scoreboardAll')"
        :text="__('messages.all_time')" />
</x-main-layout>