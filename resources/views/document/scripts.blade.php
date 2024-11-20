<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/mqtt/dist/mqtt.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// const hostIP = "192.168.0.7";
// const port = 9001;

// // Connect to the MQTT server
// var client = mqtt.connect('ws://' + hostIP + ':' + port);

// // On successful connection, subscribe to topics
// client.on('connect', function() {
//     console.log("Connected to MQTT broker");
//     client.subscribe('startsensor', function(err) {
//         if (!err) {
//             console.log("Subscribed to startsensor");
//         }
//     });
// });
// // Handle form submission for player name
// document.querySelector('#nameForm').addEventListener('submit', function(e) {
//     e.preventDefault(); // Prevent the form from submitting normally

//     const name = document.querySelector('#name').value;

//     // Send player name to the backend via fetch API
//     fetch("{{ url('api/speler') }}", {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
//                     'content')
//             },
//             body: JSON.stringify({
//                 name: name,
//                 jump: 0
//             })
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 console.log(data);
//                 client.publish('startsensor', 'start');
//                 console.log("Published 'start' to 'startsensor'");
//                 // wait for 4 seconds then redirect to the original

//                 let countdownTime = 5;

//                 // Start the countdown interval
//                 const countdownInterval = setInterval(() => {
//                     console.log(`Redirecting in ${countdownTime} seconds...`);

//                     // Decrease the countdown time
//                     countdownTime--;

//                     // When countdown reaches zero, clear interval and redirect
//                     if (countdownTime < 0) {
//                         clearInterval(countdownInterval);
//                         console.log("Redirecting now...");
//                         window.location.href =
//                             "{{ url('original') }}"; // Adjust the URL as needed
//                     }
//                 }, 1000);

//             } else {
//                 alert("Failed to save player.");
//             }
//         })
//         .catch(error => {
//             console.error('Error:', error);
//             alert("There was an error saving the player.");
//         });
// });




// Keyboard layout
// const rows = [
//     ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'],
//     ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P'],
//     ['A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L'],
//     ['Z', 'X', 'C', 'V', 'B', 'N', 'M'],
//     ['Space', 'Backspace']
// ];

// // Generate keyboard keys
// rows.forEach(row => {
//     const rowDiv = $('<div>').addClass('d-flex justify-content-center mb-2');
//     row.forEach(key => {
//         const button = $('<button>')
//             .addClass('btn btn-secondary keyboard-key')
//             .text(key === 'Space' ? '␣' : key)
//             .data('key', key)
//             .appendTo(rowDiv);
//     });
//     $('#keyboard').append(rowDiv);
// });

// // Keyboard interaction
// $('#keyboard').on('click', '.keyboard-key', function() {
//     const key = $(this).data('key');
//     const output = $('#output');
//     let currentText = output.text();

//     if (key === 'Backspace') {
//         // Remove last character
//         output.text(currentText.slice(0, -1));
//     } else if (key === 'Space') {
//         // Add a space
//         output.text(currentText + ' ');
//     } else {
//         // Add clicked key
//         output.text(currentText + key);
//     }
// });
</script>