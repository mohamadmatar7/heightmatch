@section('title', 'Leaderboard All Time')
<x-main-layout :background="'background'">
    <x-scoreboard :players="$players" :headerText="__('messages.all_time')" :route="route('scoreboardToday')"
        :text="__('messages.today')" />
</x-main-layout>