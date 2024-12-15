@section('title', 'Animals')
<x-main-layout :background="'background'">
    <div class="container py-5 my-5 rounded shadow d-flex flex-column"
        style="background-color: rgba(255, 255, 255, 0.7);">
        <!-- Title -->
        <h1 class="text-center text-success display-4 mb-4">🐾 {{ __('messages.animals') }} 🐾</h1>

        <!-- Animals Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-success">
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col">{{ __('messages.name') }}</th>
                        <th scope="col">{{ __('messages.type') }}</th>
                        <th scope="col" class="text-center">{{ __('messages.jump height') }} (cm)</th>
                        <th scope="col" class="text-center">{{ __('messages.image') }}</th>
                        <th scope="col" class="text-center">{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($animals as $index => $animal)
                    <tr>
                        <!-- Index -->
                        <th scope="row" class="text-center">
                            <span class="badge bg-success fs-6">{{ $index + 1 }}</span>
                        </th>

                        <!-- Animal Name -->
                        <td>
                            <strong class="fs-5">{{ $animal['name'] }}</strong>
                        </td>

                        <!-- Animal Type -->
                        <td>{{ $animal['type'] }}</td>

                        <!-- Jump Height -->
                        <td class="text-center">{{ $animal['jump_height'] }}</td>

                        <!-- Animal Image -->
                        <td class="text-center">
                            @if($animal['image'])
                            <img src="{{ asset($animal['image']) }}" alt="{{ $animal['name'] }}" class="img-thumbnail"
                                style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                            @else
                            <span class="text-muted">{{ __('messages.no image') }}</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" data-animal-id="{{ $animal['id'] }}">
                                {{ __('messages.delete') }}
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted fs-5">{{ __('messages.no animals found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title" id="deleteModalLabel">{{ __('messages.confirm delete') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ __('messages.are you sure you want to delete this animal?') }}
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('messages.confirm') }}</button>
                    </form>
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');

    deleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const animalId = button.getAttribute('data-animal-id'); // Extract animal ID
        const actionUrl = `{{ route('deleteAnimal', '') }}/${animalId}`; // Construct action URL
        deleteForm.setAttribute('action', actionUrl); // Update form action
    });
});
</script>