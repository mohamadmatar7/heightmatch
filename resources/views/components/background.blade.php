<section class="d-flex align-items-center justify-content-center">
    <div class="container p-5 rounded shadow bg-white"
        style="max-width: 700px; background-color: rgba(255, 255, 255, 0.9);">
        <div class="text-center">
            <!-- Title -->
            <h1 class="text-success mb-4">@yield('title', config('app.name'))</h1>
        </div>
        <form id="nameForm" action="" method="post" class="row g-3">
            <!-- Nickname Field -->
            <div class="col-md-8">
                <label for="name" class="form-label">{{ __('messages.nickname_label') }}</label>
                <input type="text" class="form-control border-success" id="name" name="name"
                    placeholder="{{ __('messages.nickname_placeholder') }}" required maxlength="50">
            </div>
            <!-- Age Field -->
            <div class="col-md-4">
                <label for="age" class="form-label">{{ __('messages.age_label') }}</label>
                <input type="number" class="form-control border-success" id="age" name="age"
                    placeholder="{{ __('messages.age_placeholder') }}" required maxlength="3"
                    oninput="validateAge(this)">
            </div>
            <!-- Submit Button -->
            <div class="col-12">
                <button type="submit" class="btn btn-success w-100">{{ __('messages.start') }}</button>
            </div>
        </form>
    </div>
</section>

<script>
function validateAge(input) {
    if (input.value.length > 3) {
        input.value = input.value.slice(0, 3); // Restrict to 3 digits
    }
}
</script>