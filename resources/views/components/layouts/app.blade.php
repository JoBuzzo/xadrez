<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <title>{{ $title ?? 'Partida de Xadrez' }}</title>
</head>

<body class="flex items-center justify-center h-screen bg-slate-200">
    {{ $slot }}
</body>

</html>
