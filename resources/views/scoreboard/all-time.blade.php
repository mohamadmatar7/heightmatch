@section('title', 'Leaderboard All Time')
<x-main-layout :background="'background'">
    <x-scoreboard :players="$players" :route="route('scoreboardToday')" :text="__('messages.today')" />
</x-main-layout>