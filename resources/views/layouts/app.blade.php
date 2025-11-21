<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Admin</title>

    @stack('styles')


    <style>
        /* Light Mode Styles */
        body.light-mode {
            background-color: #f5f7fa;
        }

        body.light-mode header {
            background-color: #ffffff;
            border-color: rgba(0, 0, 0, 0.1);
        }

        body.light-mode .text-gray-300 {
            color: #4b5563;
        }

        body.light-mode .text-white {
            color: #1f2937;
        }

        body.light-mode aside {
            background-color: #ffffff;
            border-color: rgba(0, 0, 0, 0.1);
        }

        body.light-mode .bg-\[\#0B1221\] {
            background-color: #f5f7fa;
        }

        body.light-mode .bg-\[\#1A2236\] {
            background-color: #e5e7eb;
        }

        body.light-mode .bg-\[\#11192F\] {
            background-color: #ffffff;
        }

        body.light-mode .text-gray-400,
        body.light-mode .text-gray-500 {
            color: #6b7280;
        }

        body.light-mode .placeholder-gray-500::placeholder {
            color: #9ca3af;
        }

        body.light-mode .border-white\/5,
        body.light-mode .border-white\/10 {
            border-color: rgba(0, 0, 0, 0.1);
        }

        body.light-mode .bg-white\/5,
        body.light-mode .bg-white\/10 {
            background-color: rgba(0, 0, 0, 0.05);
        }

        body.light-mode .hover\:bg-white\/10:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        body.light-mode .hover\:bg-\[\#1f2a45\]:hover {
            background-color: #d1d5db;
        }

        /* Cambia el azul fuerte a uno más suave en light mode */
        body.light-mode .bg-blue-600 {
            background-color: #bedbff !important;
        }
    </style>
</head>

<body>

    @yield('body')

    <!-- JS build (Vite) - ajusta a mix() si usas Laravel Mix -->
    @if (class_exists(\Illuminate\Foundation\Vite::class))
        @vite(['resources/js/app.js'])
    @else
        <script src="{{ mix('js/app.js') }}"></script>
    @endif

    @stack('scripts')

</body>

</html>
