<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
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
                    <h1 class="text-center text-success mb-4">{{ config('app.name', 'Animal Insights') }}</h1>


                    <!-- Form -->
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="height" class="form-label fw-bold text-dark">Jump Height (cm)</label>
                            <input type="text" class="form-control border border-success" id="height" name="height"
                                placeholder="Enter jump height" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Get Animal Data</button>
                    </form>

                    <!-- Result Section -->
                    <div class="mt-5">
                        <h2 class="text-dark">Animal Data</h2>
                        <p class="alert alert-info d-none" id="message">Animal information will appear here.</p>
                        <code class="form-control bg-light text-success p-3" id="animal"
                            style="min-height: 100px;"></code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<script>
// handle form submit
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    const height = document.querySelector('#height').value;
    fetch('/api/beestje?height=' + height)
        .then(response => response.json())
        .then(data => {
            const jsonData = JSON.stringify(data);
            const message = `
                        <p>WOOOW, je sprongetje is ${height} hoog, bijna zo hoog als een ${data.type}! met een sprongetje van ${data.jump_height}.</p>
                        <p>
                            Animal: ${data.name}<br>
                            Type: ${data.type}<br>
                            Height: ${data.jump_height}</p>
                    `;
            // beautify json
            document.querySelector('#animal').innerHTML = jsonData;
            document.querySelector('#message').innerHTML = message;
        });
});
</script>
<!-- mqtt.js -->
<script src="https://cdn.jsdelivr.net/npm/mqtt/dist/mqtt.min.js"></script>
<script>
const hostIP = "192.168.0.119";
const port = 9001;
var client = mqtt.connect('ws://' + hostIP + ':' + port);

client.on('connect', function() {
    client.subscribe('animal/heightmatch', function(err) {
        if (!err) {
            client.publish('connected', 'Hello mqtt')
        }
    })
})
client.on('message', function(topic, message) {
    // message is Buffer
    const height = message.toString();

    // add height to input field
    document.querySelector('#height').value = height;

    // auto submit after 1 second
    setTimeout(() => {
        // trigger js submit
        document.querySelector('form').dispatchEvent(new Event('submit'));
    }, 1000);


    client.end()
})
</script>

</html>