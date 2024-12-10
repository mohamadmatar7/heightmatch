@section('title', 'Animals')
<x-main-layout :background="'background'">
    <!-- Content Container -->
    <div class="container py-5 px-4 rounded shadow-lg"
        style="background-color: rgba(255, 255, 255, 0.85); max-width: 700px;">
        <!-- Title -->
        <h1 class="text-center text-success mb-5">Animals</h1>

        <!-- Table -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.type') }}</th>
                    <th>{{ __('messages.jump height') }}</th>
                    <th>{{ __('messages.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($animals as $animal)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $animal->name }}</td>
                    <td>{{ $animal->type }}</td>
                    <td>{{ $animal->jump_height }} cm</td>
                    <td>
                        <!-- Delete Form -->
                        <form action="{{ route('deleteAnimal', $animal->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this animal?');">
                                {{ __('messages.delete') }}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">{{ __('messages.no animals found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-main-layout>