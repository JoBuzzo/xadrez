<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <title>{{ $title ?? 'Page Title' }}</title>
</head>

<body class="flex items-center justify-center overflow-x-hidden bg-gray-100">
    {{ $slot }}
</body>

</html>
