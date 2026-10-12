<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Helpdesk Prijava</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* ZAMUÆENA SLIKA TVORNICE */
            .zamucena-pozadina {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-image: url('{{ asset('pozadina.jpg') }}');
                background-size: cover;
                background-position: center;
                filter: blur(8px); 
                transform: scale(1.05); 
                z-index: -1; 
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        
        <div class="zamucena-pozadina"></div>

        <!-- Uklonjen justify-center i dodan padding-top od 12vh za podizanje prema vrhu -->
        <div class="min-h-screen flex flex-col items-center relative z-10" style="padding-top: 12vh;">
            
            <!-- LOGOTIP -->
            <div style="margin-bottom: 25px;">
                <a href="/">
                    <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 320px; max-width: 100%; mix-blend-mode: multiply;">
                </a>
            </div>

            <!-- LOGIN FORMA -->
            <div class="w-full sm:max-w-lg px-10 py-12 shadow-2xl overflow-hidden"
                 style="background-color: rgba(255, 255, 255, 0.90); border: 1px solid rgba(255, 255, 255, 0.5); border-radius: 25px;">
                {{ $slot }}
            </div>
            
        </div>
    </body>
</html>