<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('storage/images/project/favicon/favicon-96x96.png')}}"
        sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/images/project/favicon/favicon.svg')}}" sizes="any" />
    <link rel="shortcut icon" href="{{ asset('storage/images/project/favicon/favicon.ico')}}" />
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('storage/images/project/favicon/apple-touch-icon.png')}}" />
    <meta name="apple-mobile-web-app-title" content="MyWebSite" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else

    @endif
    <!-- bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Main Wrapper with Background Image -->
    <div class="d-flex align-items-center justify-content-center min-vh-100"
        style="background-image: url('{{ asset('storage/images/project/background.png') }}'); background-size: cover; background-repeat: no-repeat;">
        <!-- Content Container -->
        <div class="container m-5 p-5 rounded shadow bg-white"
            style="max-width: 50%; background-color: rgba(255, 255, 255, 0.9);">
            <div class="row">
                <div class="col-md-12">
                    <!-- Title -->
                    <h1 class="text-center text-success mb-4">{{ config('app.name', 'HeightMatch') }}</h1>

                    <!-- Info of the player with heighst jump -->
                    <div class="alert alert-warning">
                        <h4 class="text-dark">Player with highest jump</h4>
                        <p class="text-dark mb-0">Name: <strong>{{ $player->name }}</strong></p>
                        <p class="text-dark mb-0">Jump Height: <strong>{{ $player->jump }}</strong></p>
                    </div>
                    <!-- Form to Enter Player Name -->
                    <h4 class="text-dark">Enter Your Information</h4>
                    <form id="nameForm" action="" method="post">
                        <div class="mb-2">
                            <label for="name" class="form-label mb-0">Name</label>
                            <input type="text" class="form-control border border-success" id="name" name="name"
                                placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label mb-0">Age</label>
                            <input type="number" class="form-control border border-success" id="age" name="age"
                                placeholder="Enter your age" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Start</button>
                    </form>
                </div>
            </div>
        </div>



        <div class="container mt-4">
            <h2 class="text-center">Touchscreen Keyboard</h2>
            <div id="output" class="mb-3"></div>
            <div id="keyboard" class="d-flex flex-wrap justify-content-center">
                <!-- Keys will be dynamically added here -->
            </div>
        </div>
    </div>




    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mqtt/dist/mqtt.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    const hostIP = "192.168.0.119";
    const port = 9001;

    // Connect to the MQTT server
    var client = mqtt.connect('ws://' + hostIP + ':' + port);

    // On successful connection, subscribe to topics
    client.on('connect', function() {
        console.log("Connected to MQTT broker");
        client.subscribe('startsensor', function(err) {
            if (!err) {
                console.log("Subscribed to startsensor");
            }
        });
    });
    // Handle form submission for player name
    document.querySelector('#nameForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        const name = document.querySelector('#name').value;

        // Send player name to the backend via fetch API
        fetch("{{ url('api/speler') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    name: name,
                    jump: 0
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log(data);
                    client.publish('startsensor', 'start');
                    console.log("Published 'start' to 'startsensor'");
                    // wait for 4 seconds then redirect to the original

                    let countdownTime = 5;

                    // Start the countdown interval
                    const countdownInterval = setInterval(() => {
                        console.log(`Redirecting in ${countdownTime} seconds...`);

                        // Decrease the countdown time
                        countdownTime--;

                        // When countdown reaches zero, clear interval and redirect
                        if (countdownTime < 0) {
                            clearInterval(countdownInterval);
                            console.log("Redirecting now...");
                            window.location.href =
                                "{{ url('original') }}"; // Adjust the URL as needed
                        }
                    }, 1000);

                } else {
                    alert("Failed to save player.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("There was an error saving the player.");
            });
    });




    // Keyboard layout
    const rows = [
        ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'],
        ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P'],
        ['A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L'],
        ['Z', 'X', 'C', 'V', 'B', 'N', 'M'],
        ['Space', 'Backspace']
    ];

    // Generate keyboard keys
    rows.forEach(row => {
        const rowDiv = $('<div>').addClass('d-flex justify-content-center mb-2');
        row.forEach(key => {
            const button = $('<button>')
                .addClass('btn btn-secondary keyboard-key')
                .text(key === 'Space' ? '␣' : key)
                .data('key', key)
                .appendTo(rowDiv);
        });
        $('#keyboard').append(rowDiv);
    });

    // Keyboard interaction
    $('#keyboard').on('click', '.keyboard-key', function() {
        const key = $(this).data('key');
        const output = $('#output');
        let currentText = output.text();

        if (key === 'Backspace') {
            // Remove last character
            output.text(currentText.slice(0, -1));
        } else if (key === 'Space') {
            // Add a space
            output.text(currentText + ' ');
        } else {
            // Add clicked key
            output.text(currentText + key);
        }
    });
    </script>
</body>

</html>