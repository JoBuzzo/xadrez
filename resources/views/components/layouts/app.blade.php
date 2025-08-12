<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css', 'resources/js/app.css')
    <title>{{ $title ?? 'Page Title' }}</title>
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('cfb5481c8ccf4afa2a3d', {
            cluster: 'sa1'
        });

        var channel = pusher.subscribe('new-move');
        channel.bind('moved-piece', function(data) {
            alert(JSON.stringify(data));
        });
    </script>
</head>

<body class="flex items-center justify-center overflow-x-hidden bg-gray-100">
    {{ $slot }}
</body>

</html>
