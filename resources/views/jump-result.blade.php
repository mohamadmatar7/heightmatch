@section('title', 'Jump Result')
<x-main-layout :background="'background'">
    <!-- Content Container -->
    <div class="container py-5 px-4 rounded shadow-lg"
        style="background-color: rgba(255, 255, 255, 0.85); max-width: 700px;">
        <!-- Title -->
        <h1 class="text-center text-success mb-5">{{ config('app.name', 'Animal Insights') }}</h1>


        <!-- User Jump Height -->
        <div id="user-jump-height" class="text-center mb-4">
            <strong class="fs-4">{{ __('messages.your') }} {{ __('messages.jump height') }}:</strong>
            <div class="badge bg-success fs-4 px-3 py-2" id="jump-height-value">{{ __('messages.loading') }}...</div>
        </div>

        <!-- Animal Data Section -->
        <div id="animal-info" class="d-none">
            <div class="d-flex flex-column gap-3">
                <!-- Animal Image -->
                <div class="text-center">
                    <img src="" alt="Animal Image" id="animal-image" class="img-fluid rounded shadow-sm border"
                        style="max-height: 300px; object-fit: cover; width: auto;">
                </div>

                <!-- Animal Details -->
                <div class="text-center">
                    <h5 class="text-success fw-bold" data-animal-name="animal-name"></h5>
                    <p class="text-muted" id="animal-description"></p>
                </div>

                <!-- Animal Attributes Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="table-success">
                                <th scope="col">{{ __('messages.attribute') }}</th>
                                <th scope="col">{{ __('messages.value') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>{{ __('messages.name') }}</strong></td>
                                <td data-animal-name="animal-name"></td>
                            </tr>
                            <tr>
                                <td><strong>{{ __('messages.type') }}</strong></td>
                                <td id="animal-type"></td>
                            </tr>
                            <tr>
                                <td><strong>{{ __('messages.jump height of') }} <span
                                            data-name="animal-name"></span></strong>
                                </td>
                                <td><span id="animal-jump-height"></span> cm</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="text-center my-4">
            <a href="{{ route('scoreboardToday') }}" class="btn btn-success w-50 fs-4">
                {{ __('messages.leaderboard') }}
            </a>
        </div>


        <!-- Info Message Section -->
        <div id="message" class="alert alert-danger text-center mt-4 d-none"></div>
    </div>
</x-main-layout>


<script>
// Function to extract query parameters
function getQueryParam(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

// Get player ID from URL
const playerId = getQueryParam('player_id');

if (!playerId) {
    alert('Player information is missing. Please start again.');
    window.location.href = '/';
}

// MQTT Setup
const hostIP = "192.168.0.119";
const port = 9001;
const client = mqtt.connect(`ws://${hostIP}:${port}`);

client.on('connect', function() {
    console.log('Connected to MQTT broker.');
    client.subscribe('animal/heightmatch', function(err) {
        if (!err) {
            console.log('Subscribed to topic: animal/heightmatch');
        } else {
            console.error('Failed to subscribe to topic:', err);
        }
    });
});

client.on('message', function(topic, message) {
    // Message contains the height data
    const height = message.toString();
    console.log('Received height:', height);

    // Update the displayed jump height
    const jumpHeightDisplay = document.querySelector('#jump-height-value');
    jumpHeightDisplay.textContent = height + ' cm';

    // Ensure the player ID exists
    if (!playerId) {
        console.error('Player ID is missing.');
        return;
    }

    // Update the player's jump height in the database
    fetch(`/api/update-player-jump`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                player_id: playerId,
                jump: height
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Player jump updated successfully:', data.player);

                // Fetch animal data based on the received height
                fetch(`/api/beestje?height=${height}`)
                    .then(response => response.json())
                    .then(animalData => {
                        // Update animal info on the page
                        document.querySelector('#animal-info').classList.remove('d-none');
                        document.querySelectorAll('[data-animal-name="animal-name"]').forEach(
                            element => {
                                element.textContent = animalData.name;
                            });
                        document.querySelector('#animal-description').textContent = animalData
                            .description;
                        document.querySelector('#animal-type').textContent = animalData.type;
                        document.querySelector('#animal-jump-height').textContent = animalData
                            .jump_height;
                        document.querySelector('#animal-image').src = animalData.image_url;

                        // Hide the info message
                        document.querySelector('#message').classList.add('d-none');
                    })
                    .catch(error => {
                        console.error('Error fetching animal data:', error);
                        const messageElement = document.querySelector('#message');
                        messageElement.classList.remove('d-none');
                        messageElement.textContent = 'Error fetching animal data.';
                    });
            } else {
                console.error('Failed to update player jump:', data.message);
            }
        })
        .catch(error => {
            console.error('Error updating player jump:', error);
        });
});

client.on('error', function(err) {
    console.error('MQTT Connection Error:', err);
});
</script>