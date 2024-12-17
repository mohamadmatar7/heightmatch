@props(['players', 'headerText', 'route', 'text'])
<div class="container py-5 my-5 rounded shadow d-flex flex-column " style="background-color: rgba(255, 255, 255, 0.7);">
    <!-- Page Title -->
    <h1 class="text-center text-success display-4 mb-4">🏆
        {{ $headerText }} {{ __('messages.leaderboard') }} 🏆</h1>
    <div>
        <a href="{{ $route }}" class="btn btn-success mb-2">
            {{ $text }}
        </a>
        <a href="/" class="btn btn-outline-success mb-2 ms-2">
            {{ __('messages.home') }}
        </a>
    </div>

    <!-- Scoreboard Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-success">
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col">{{ __('messages.player') }}</th>
                    <th scope="col">{{ __('messages.age') }}</th>
                    <th scope="col" class="text-center">{{ __('messages.height') }} (cm)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($players as $index => $player)
                <tr>
                    <!-- Ranking -->
                    <th scope="row" class="text-center">
                        <span class="badge bg-success fs-6">{{ $index + 1 }}</span>
                    </th>

                    <!-- Player Details -->
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="ms-2">
                                <strong class="fs-5">{{ $player->name }}</strong>
                            </div>
                        </div>
                    </td>

                    <!-- Player Age -->
                    <td>{{ $player->age }}</td>

                    <!-- Player Jump -->
                    <td class="text-center">
                        <strong class="fs-5 text-success">{{ $player->jump }}</strong>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted fs-5">
                        {{ __('messages.no players found') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>