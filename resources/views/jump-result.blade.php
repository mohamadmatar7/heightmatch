<x-main-layout :background="'background'">
    <!-- Content Container -->
    <div class="container p-5 rounded shadow" style="background-color: rgba(255, 255, 255, 0.7);">
        <div class="row">
            <div class="col-md-12">
                <!-- Title -->
                <h1 class="text-center text-success mb-4">{{ config('app.name', 'Animal Insights') }}</h1>

                <!-- Form (hidden) -->
                <form action="" method="post" class="d-none">
                    @csrf
                    <input type="hidden" class="form-control border border-success" id="height" name="height" required>
                </form>

                <!-- Display User Jump Height -->
                <div id="user-jump-height" class="mb-4">
                    <strong>Your Jump Height: <span id="jump-height-value">Loading...</span>
                        cm</strong>
                </div>

                <!-- Animal Data Section -->
                <div id="animal-info" class="d-none">
                    <div class="card">
                        <img src="" alt="Animal Image" id="animal-image" class="card-img-top"
                            style="max-height: 300px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title" id="animal-name"></h5>
                            <p class="card-text" id="animal-description"></p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Type:</strong> <span id="animal-type"></span></li>
                                <li class="list-group-item"><strong>Jump Height:</strong> <span
                                        id="animal-jump-height"></span> cm</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Info Message Section -->
                <p class="alert alert-info d-none" id="message">Animal information will appear here.</p>
            </div>
        </div>
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

if (playerId) {
    console.log('Player ID:', playerId);
} else {
    alert('Player information is missing. Please start again.');
    window.location.href = '/';
}

// handle form submit
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    const height = document.querySelector('#height').value;
    fetch('/api/beestje?height=' + height)
        .then(response => response.json())
        .then(data => {
            // Set the animal data
            document.querySelector('#animal-name').textContent = data.name;
            document.querySelector('#animal-type').textContent = data.type;
            document.querySelector('#animal-jump-height').textContent = data.jump_height;
            document.querySelector('#animal-description').textContent = data.description;
            document.querySelector('#animal-image').src = data.image;

            // Show the animal data section
            document.querySelector('#animal-info').classList.remove('d-none');
            document.querySelector('#message').classList.add('d-none');
        })
        .catch(error => {
            console.error('Error fetching animal data:', error);
        });
});

// MQTT Setup
const hostIP = "192.168.0.7";
const port = 9001;
var client = mqtt.connect('ws://' + hostIP + ':' + port);

client.on('connect', function() {
    client.subscribe('animal/heightmatch', function(err) {
        if (!err) {
            client.publish('connected', 'Hello mqtt');
        }
    });
});

client.on('message', function(topic, message) {
    // message is Buffer
    const height = message.toString();
    console.log('Received height:', height);

    // Update the jump height value on the page
    document.querySelector('#jump-height-value').textContent = height;

    // Ensure the player ID exists
    if (!playerId) {
        console.error('Player ID is missing.');
        return;
    }

    // Automatically update the player's jump in the database
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
                document.querySelector('#message').classList.remove('d-none');
                document.querySelector('#message').textContent =
                    `Jump height updated to ${height} for player ${data.player.name}!`;
            } else {
                console.error('Failed to update player jump:', data.message);
            }
        })
        .catch(error => {
            console.error('Error updating player jump:', error);
        });

    // Optionally auto-submit the height to fetch animal data
    document.querySelector('#height').value = height;
    setTimeout(() => {
        document.querySelector('form').dispatchEvent(new Event('submit'));
    }, 1000);

    client.end();
});
</script>