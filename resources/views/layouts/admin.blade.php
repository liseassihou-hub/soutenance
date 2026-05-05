<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>PEBCO Admin - {{ $title ?? 'Tableau de Bord' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Stack for additional styles -->
    @stack('styles')
    
    <!-- Custom CSS -->
    <style>
        /* Custom styles for admin dashboard */
        .bg-green-50 {
            background-color: #f0fdf4 !important;
        }
        .bg-green-900 {
            background-color: #0fa54b !important;
        }
        .bg-green-800 {
            background-color: #1a8d46 !important;
        }
        .bg-green-700 {
            background-color: #f0f5f2 !important;
        }
        .bg-green-600 {
            
            background-color: #16a34a !important;
        }
        .text-green-900 {
            color: #14532d !important;
        }
        .text-green-700 {
            color: #15803d !important;
        }
        .text-green-600 {
            color: #16a34a !important;
        }
        .text-green-300 {
            color: #86efac !important;
        }
        .text-green-200 {
            color: #bbf7d0 !important;
        }
        .text-green-100 {
            color: #dcfce7 !important;
        }
        .border-green-200 {
            border-color: #bbf7d0 !important;
        }
        .border-green-300 {
            border-color: #86efac !important;
        }
        .hover\:bg-green-800:hover {
            background-color: #16a34a !important;
        }
        .hover\:bg-green-700:hover {
            background-color: #34a760  !important;
            
        }


        .hover\:text-white:hover {
            color: #ffffff !important;
        }
        
        /* Fix sidebar transitions */
        .transition-transform {
            transition: transform 0.3s ease;
        }
        
        /* Fix card shadows */
        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06) !important;
        }
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        }
        
        /* Fix responsive issues */
        @media (max-width: 1024px) {
            .lg\:block {
                display: none !important;
            }
        }
        @media (min-width: 1024px) {
            .lg\:block {
                display: block !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    @yield('content')
    
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
