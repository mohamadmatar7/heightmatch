<section class="d-flex align-items-center justify-content-center">
    <div class="container p-5 rounded shadow bg-white"
        style="max-width: 700px; background-color: rgba(255, 255, 255, 0.9);">
        <div class="text-center">
            <!-- Title -->
            <h1 class="text-success mb-4 display-4">@yield('title', config('app.name'))</h1>
        </div>

        <form id="nameForm" action="" method="post" class="row g-3">
            @csrf
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
                    placeholder="{{ __('messages.age_placeholder') }}" required maxlength="3">
            </div>

            <!-- Keyboard Layout -->
            <div id="keyboard" class="col-12 mt-3 d-flex flex-wrap justify-content-center">
                <!-- Keys will be dynamically added here -->
            </div>

            <!-- Submit Button -->
            <div class="col-12 mt-3">
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




// Keyboard layout
const rows = [
    ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'],
    ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P'],
    ['A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L'],
    ['Z', 'X', 'C', 'V', 'B', 'N', 'M'],
    ['Space', '.', 'Backspace']
];

// Generate keyboard keys dynamically
rows.forEach(row => {
    const rowDiv = $('<div>').addClass('d-flex justify-content-center mb-2');
    row.forEach(key => {
        const button = $('<button>')
            .addClass('btn btn-outline-success mx-1 keyboard-key px-3')
            .text(key === 'Space' ? '␣' : key)
            .data('key', key)
            .appendTo(rowDiv);
    });
    $('#keyboard').append(rowDiv);
});

// Focus tracking: keep track of the currently focused input field
let activeInput = null;
$('#name, #age').on('focus', function() {
    activeInput = $(this);
});

// Handle keyboard interaction with input fields
$('#keyboard').on('click', '.keyboard-key', function(event) {
    event.preventDefault(); // Prevent form submission or other default behavior when clicking on a key

    const key = $(this).data('key');

    // Check if there is an active input field
    if (activeInput) {
        let currentText = activeInput.val();

        if (key === 'Backspace') {
            // Remove last character
            activeInput.val(currentText.slice(0, -1));
        } else if (key === 'Space') {
            // Add a space
            activeInput.val(currentText + ' ');
        } else {
            // Add clicked key
            activeInput.val(currentText + key);
        }
    }
});

// Prevent form submission when pressing "Enter" while focused on the inputs
$('#nameForm').on('submit', function(event) {
    event.preventDefault(); // Prevent automatic submission
});
</script>