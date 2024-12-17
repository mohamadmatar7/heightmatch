<section class="d-flex align-items-center justify-content-center">
    <div class="container p-5 rounded shadow" style="background-color: rgba(255, 255, 255, 0.7);" id="content">
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
                <input type="number" class="form-control border-success" id="age" name="age" min="8" max="99"
                    placeholder="{{ __('messages.age_placeholder') }}" required maxlength="3">
            </div>

            <!-- Keyboard Layout -->
            <div id="keyboard" class="col-12 mt-3 d-flex flex-wrap justify-content-center">
                <!-- Keys will be dynamically added here -->
            </div>

            <!-- Submit Button -->
            <div class="col-12 mt-3 text-center">
                <button type="submit" class="btn btn-success w-50 fs-4">{{ __('messages.start') }}</button>
            </div>
        </form>
    </div>
    <div class="countdown-overlay text-success fw-semibold d-none" id="countdown-overlay" style="font-size: 13rem;">
    </div>
</section>

<!-- Modal for displaying error message -->
<div class="modal fade" id="badWordsModal" tabindex="-1" aria-labelledby="badWordsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="badWordsModalLabel">{{__('messages.invalid input')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('messages.please avoid using inappropriate language in your nickname.') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">{{ __('messages.close') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for invalid age -->
<div class="modal fade" id="invalidAgeModal" tabindex="-1" aria-labelledby="invalidAgeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invalidAgeModalLabel">{{__('messages.invalid input')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('messages.age must be between 8 and 99.') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">{{ __('messages.close') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('name').focus();
});

// List of bad words
const badWords = ['fuck', 'sex', 'bitch', 'asshole', 'shit', 'damn'];

// Function to check if the input contains any bad words
function containsBadWords(inputValue) {
    const normalizedInput = inputValue.toLowerCase();
    return badWords.some(badWord => normalizedInput.includes(badWord));
}

// Keyboard layout
const rows = [
    ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-'],
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
            .addClass('btn btn-outline-success mx-2 keyboard-key px-4 py-3 fs-5')
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

// Handle virtual keyboard interaction with input fields
$('#keyboard').on('click', '.keyboard-key', function(event) {
    event.preventDefault(); // Prevent form submission or other default behavior when clicking on a key

    const key = $(this).data('key');

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

// Prevent Enter key from adding a number to the 'age' field but allow form submission
document.querySelector('#nameForm').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();

        const activeElement = document.activeElement;

        // Check if the active element is the 'age' input
        if (activeElement && activeElement.id === 'age') {
            // Trigger form submission but don't modify the input
            this.dispatchEvent(new Event('submit', {
                cancelable: true
            }));
        }
    }
});

// Form submission handler
document.querySelector('#nameForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const name = document.querySelector('#name').value;
    const ageField = document.querySelector('#age');
    const age = parseInt(ageField.value, 10);

    // Check if name contains bad words
    if (containsBadWords(name)) {
        const modal = new bootstrap.Modal(document.getElementById('badWordsModal'));
        modal.show();
        return; // Stop the form from being submitted
    }

    // Validate the age
    const minAge = parseInt(ageField.getAttribute('min'), 10);
    const maxAge = parseInt(ageField.getAttribute('max'), 10);
    if (isNaN(age) || age < minAge || age > maxAge) {
        const invalidAgeModal = new bootstrap.Modal(document.getElementById('invalidAgeModal'));
        invalidAgeModal.show();
        return; // Stop the form from being submitted
    }

    // Submit the data to the server
    fetch("{{ url('api/speler') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name,
                age,
                jump: 0
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                handleGameStart(data);
            } else {
                alert("Failed to save player.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("There was an error saving the player.");
        });
});

// Helper: Handle the game start logic
function handleGameStart(data) {
    client.publish('startsensor', 'start');
    console.log("Published 'start' to 'startsensor'");

    // Hide the form
    const content = document.querySelector('#content');
    content.classList.add('d-none');

    // Show the countdown overlay
    const overlay = document.querySelector('#countdown-overlay');
    overlay.classList.remove('d-none');
    const jumpText = @json(__('messages.jump!'));

    let countdownTime = 3;
    overlay.textContent = countdownTime;

    const countdownInterval = setInterval(() => {
        countdownTime--;

        if (countdownTime > 0) {
            overlay.textContent = countdownTime;
        } else {
            clearInterval(countdownInterval);
            overlay.textContent = jumpText;

            setTimeout(() => {
                // Redirect after "Jump!" is displayed
                window.location.href = `/result?player_id=${data.player.id}`;
            }, 3200);
        }
    }, 1250);
}

// Connect to the MQTT server
const hostIP = "192.168.0.7";
const port = 9001;

var client = mqtt.connect('ws://' + hostIP + ':' + port);

client.on('connect', function() {
    console.log("Connected to MQTT broker");
    client.subscribe('startsensor', function(err) {
        if (!err) {
            console.log("Subscribed to startsensor");
        }
    });
});
</script>