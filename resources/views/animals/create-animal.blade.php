@section('title', 'Create Animal')
<x-main-layout :background="'background'">
    <!-- Content Container -->
    <div class="container py-5 px-4 rounded shadow-lg"
        style="background-color: rgba(255, 255, 255, 0.85); max-width: 700px;">
        <form action="{{ route('storeAnimal') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- Title -->
            <h1 class=" text-center text-success mb-5">{{ config('app.name', 'Animal Insights') }}</h1>
            <!-- Animal Name -->
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('messages.name') }}</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <!-- Animal Type -->
            <div class="mb-3">
                <label for="type" class="form-label">{{ __('messages.type') }}</label>
                <input type="text" class="form-control" id="type" name="type" required>
            </div>
            <!-- Animal Jump Height -->
            <div class="mb-3">
                <label for="jump_height" class="form-label">{{ __('messages.jump height') }}</label>
                <input type="number" class="form-control" id="jump_height" name="jump_height" required>
            </div>
            <!-- Animal Description-->
            <div class="mb-3">
                <label for="description" class="form-label">{{ __('messages.description') }}</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <!-- Animal Image -->
            <div class="mb-3">
                <label for="image" class="form-label">{{ __('messages.image') }}</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-success">{{ __('messages.post') }}</button>
        </form>
    </div>
</x-main-layout>