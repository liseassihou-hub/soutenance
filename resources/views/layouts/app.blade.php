<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>PEBCO - {{ $title ?? 'Institution de Microfinance' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=open+sans:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Stack for additional styles -->
    @stack('styles')
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-green: #1e5e1e;
            --light-green: #2d7a2d;
            --dark-green: #144614;
            --accent-green: #4caf50;
            --success-green: #66bb6a;
            --text-primary: #1a1a1a;
            --text-secondary: #4a4a4a;
            --text-muted: #6c757d;
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --bg-light: #f5f7f5;
            --border-color: #e9ecef;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.16);
            --transition-base: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text-primary);
            line-height: 1.6;
            font-weight: 400;
            background-color: var(--bg-primary);
            overflow-x: hidden;
            max-width: 100%;
            width: 100%;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            font-weight: 600;
            line-height: 1.3;
        }
        
        /* Appliquer les polices uniformément à tout le système */
        * {
            font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        
        /* Responsive credit button */
        @media (max-width: 576px) {
            .credit-btn {
                padding: 0.75rem 1.5rem;
                font-size: 0.9rem;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                white-space: nowrap;
            }
        }
        
        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif !important;
        }
        
                
        .font-poppins {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif !important;
        }
        
        .font-open-sans {
            font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: var(--transition-base);
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1030 !important;
            padding: 1rem 0;
        }
        
        .navbar.scrolled {
            padding: 0.5rem 0;
            box-shadow: var(--shadow-md);
        }
        
        .navbar-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.75rem;
            color: var(--primary-green) !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: var(--transition-base);
        }
        
        .navbar-brand:hover {
            transform: translateY(-1px);
            color: var(--dark-green) !important;
        }
        
        .navbar-brand i {
            font-size: 1.5rem;
        }
        
        .navbar-nav .nav-link {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            color: var(--text-primary) !important;
            margin: 0 0.75rem;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: var(--transition-base);
            position: relative;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--primary-green) !important;
            background-color: rgba(30, 94, 30, 0.08);
        }
        
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--primary-green);
            transition: var(--transition-base);
        }
        
        .navbar-nav .nav-link:hover::after {
            width: 80%;
        }
        
        .hero-section {
            position: relative;
            height: 100vh;
            min-height: 600px;
            margin-top: 80px;
            margin-left: 0;
            margin-right: 0;
            padding: 0;
            background: linear-gradient(135deg, 
                #0d3d0d 0%, 
                #1e5e1e 30%, 
                #2d7d2d 60%, 
                #0a3d0a 100%);
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(76, 175, 80, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(46, 125, 50, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(102, 187, 106, 0.05) 0%, transparent 50%);
            z-index: 1;
        }
        
        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
            z-index: 2;
        }
        
        .hero-slider {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            pointer-events: none;
        }

        .hero-slider .swiper-slide {
            position: relative;
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.3) 50%, rgba(0, 0, 0, 0.2) 100%);
            z-index: 1;
            pointer-events: none;
        }
        
        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            text-align: center;
            color: white;
            max-width: 900px;
            padding: 100px 2rem 0 2rem;
            pointer-events: auto;
        }
        
        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            letter-spacing: -0.02em;
        }
        
        .hero-subtitle {
            font-family: 'Open Sans', sans-serif;
            font-size: clamp(1.1rem, 2.5vw, 1.4rem);
            font-weight: 400;
            margin-bottom: 2.5rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            opacity: 0.95;
            line-height: 1.6;
        }
        
        .credit-btn {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%);
            color: white;
            padding: 1rem 2.5rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            border: none;
            border-radius: 50px;
            transition: var(--transition-base);
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 16px rgba(30, 94, 30, 0.3);
            position: relative;
            overflow: hidden;
            cursor: pointer;
            z-index: 10;
            pointer-events: auto;
        }
        
        .credit-btn:hover {
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(30, 94, 30, 0.4);
            text-decoration: none;
        }
        
        .hero-buttons {
            position: relative;
            z-index: 10;
        }
        
        .section-padding {
            padding: 6rem 0;
        }
        
        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 1rem;
            text-align: center;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-green));
            border-radius: 2px;
        }
        
        .section-subtitle {
            font-family: 'Open Sans', sans-serif;
            font-size: 1.2rem;
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 4rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.7;
        }
        
        .credit-card {
            background: var(--bg-primary);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: var(--transition-base);
            height: 100%;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .credit-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
        }
        
        .credits-carousel {
            padding: 20px 0;
        }

        .credits-carousel .swiper-slide {
            height: auto;
        }

        .credits-carousel .credit-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            height: 440px !important;
        }

        .credits-carousel .credit-card .card-img-wrapper {
            height: 280px !important;
            overflow: hidden;
        }

        .credits-carousel .credit-card .card-img-top {
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .credits-carousel .credit-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .credits-carousel .credit-card .card-body {
            height: 160px !important;
            padding: 1rem !important;
            display: flex;
            flex-direction: column;
        }

        .credits-carousel .credit-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .stat-number {
            font-size: 2.8rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1;
            margin-bottom: 0.5rem;
            display: inline-block;
            font-family: 'Poppins', sans-serif;
            text-shadow: 
                0 0 20px rgba(0, 0, 0, 0.8),
                0 0 40px rgba(0, 0, 0, 0.6),
                0 2px 4px rgba(0, 0, 0, 0.9);
        }
        
        .stat-plus, .stat-percent {
            font-size: 1.6rem;
            font-weight: 800;
            color: #4ade80;
            margin-left: 0.2rem;
            display: inline-block;
            vertical-align: top;
            text-shadow: 
                0 0 20px rgba(0, 0, 0, 0.8),
                0 0 40px rgba(0, 0, 0, 0.6),
                0 2px 4px rgba(0, 0, 0, 0.9);
        }
        
        .stat-label {
            font-size: 1rem;
            color: #ffffff;
            font-weight: 700;
            margin-top: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-family: 'Open Sans', sans-serif;
            text-shadow: 
                0 0 15px rgba(0, 0, 0, 0.8),
                0 0 30px rgba(0, 0, 0, 0.6),
                0 1px 3px rgba(0, 0, 0, 0.9);
        }
        
        /* Mobile Menu Styles */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--primary-green);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .mobile-menu-toggle:hover {
            background-color: rgba(30, 94, 30, 0.1);
        }
        
        .mobile-nav {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            z-index: 1040;
            padding: 2rem;
            overflow-y: auto;
        }
        
        .mobile-nav.active {
            display: block;
        }
        
        .mobile-nav-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            color: var(--primary-green);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
        }
        
        .mobile-nav-content {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 3rem;
        }
        
        .mobile-nav-link {
            display: block;
            padding: 1rem;
            background: rgba(30, 94, 30, 0.05);
            border-radius: 12px;
            color: var(--text-primary);
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .mobile-nav-link:hover {
            background: rgba(30, 94, 30, 0.1);
            color: var(--primary-green);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero-content {
                padding: 90px 1.5rem 0 1.5rem;
                max-width: 800px;
            }
            
            .hero-title {
                font-size: clamp(2.2rem, 6vw, 3.5rem);
            }
            
            .navbar-nav {
                display: none;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
        }
        
        @media (max-width: 768px) {
            .section-padding {
                padding: 4rem 0;
            }
            
            .hero-section {
                height: 90vh;
                min-height: 500px;
                margin-top: 70px;
            }
            
            .hero-content {
                padding: 80px 1rem 0 1rem;
                max-width: 100%;
            }
            
            .hero-title {
                font-size: clamp(2rem, 7vw, 3rem);
                line-height: 1.2;
            }
            
            .hero-subtitle {
                font-size: 1rem;
                line-height: 1.5;
                margin-bottom: 1.5rem;
            }
            
            .credit-btn {
                padding: 0.875rem 2rem;
                font-size: 1rem;
                margin-top: 0.5rem;
            }
            
            .navbar {
                padding: 0.75rem 0;
            }
            
            .navbar-brand {
                font-size: 1.5rem;
            }
            
            .navbar-nav .nav-link {
                margin: 0 0.25rem;
                padding: 0.375rem 0.5rem !important;
                font-size: 0.9rem;
            }
            
            .grid-cols-1.lg\:grid-cols-2 {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .grid-cols-1.md\:grid-cols-2.lg\:grid-cols-4 {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .section-padding {
                padding: 3rem 0;
            }
            
            .hero-section {
                height: 80vh;
                min-height: 400px;
                margin-top: 50px;
            }
            
            .hero-content {
                padding: 50px 0.5rem 0 0.5rem;
            }
            
            .hero-title {
                font-size: clamp(1.5rem, 9vw, 2.25rem);
            }
            
            .hero-subtitle {
                font-size: 0.85rem;
                margin-bottom: 1rem;
            }
            
            .credit-btn {
                padding: 0.625rem 1.5rem;
                font-size: 0.85rem;
            }
            
            .navbar-brand {
                font-size: 1.125rem;
            }
            
            .navbar-nav .nav-link {
                font-size: 0.75rem;
                padding: 0.2rem 0.3rem !important;
            }
            
            .code-text {
                font-size: 1.4rem;
                letter-spacing: 0.5px;
            }
            
            .code-modal-container {
                width: 95%;
                margin: 10px;
            }
            
            .code-modal-content {
                padding: 1.5rem;
            }
            
            .code-modal-header h3 {
                font-size: 1.25rem;
            }
            
            .code-form-group {
                margin-bottom: 1rem;
            }
            
            .code-input {
                font-size: 1rem;
                padding: 0.75rem;
            }
            
            .code-submit-btn {
                padding: 0.75rem 1.5rem;
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 480px) {
            .hero-section {
                height: 70vh;
                min-height: 300px;
                margin-top: 30px;
            }
            
            .hero-content {
                padding: 30px 0.25rem 0 0.25rem;
            }
            
            .hero-title {
                font-size: clamp(1.2rem, 10vw, 2rem);
            }
            
            .hero-subtitle {
                font-size: 0.75rem;
                margin-bottom: 0.75rem;
            }
            
            .credit-btn {
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
            }
            
            .navbar-brand {
                font-size: 1rem;
            }
            
            .navbar-nav .nav-link {
                font-size: 0.65rem;
                padding: 0.15rem 0.25rem !important;
            }
            
            .code-text {
                font-size: 1.2rem;
                letter-spacing: 0;
            }
            
            .code-modal-container {
                width: 98%;
                margin: 5px;
            }
            
            .code-modal-content {
                padding: 1rem;
            }
            
            .code-modal-header h3 {
                font-size: 1.1rem;
            }
            
            .code-form-group {
                margin-bottom: 0.75rem;
            }
            
            .code-input {
                font-size: 0.9rem;
                padding: 0.5rem;
            }
            
            .code-submit-btn {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }
        }
        
        @media (max-width: 360px) {
            .hero-section {
                height: 60vh;
                min-height: 250px;
                margin-top: 20px;
            }
            
            .hero-content {
                padding: 20px 0.1rem 0 0.1rem;
            }
            
            .hero-title {
                font-size: clamp(1rem, 11vw, 1.75rem);
            }
            
            .hero-subtitle {
                font-size: 0.65rem;
                margin-bottom: 0.5rem;
            }
            
            .credit-btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.65rem;
            }
            
            .navbar-brand {
                font-size: 0.875rem;
            }
            
            .navbar-nav .nav-link {
                font-size: 0.55rem;
                padding: 0.1rem 0.2rem !important;
            }
            
            .code-text {
                font-size: 1rem;
                letter-spacing: 0;
            }
            
            .code-modal-container {
                width: 100%;
                margin: 0;
            }
            
            .code-modal-content {
                padding: 0.75rem;
            }
            
            .code-modal-header h3 {
                font-size: 1rem;
            }
            
            .code-form-group {
                margin-bottom: 0.5rem;
            }
            
            .code-input {
                font-size: 0.8rem;
                padding: 0.375rem;
            }
            
            .code-submit-btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.7rem;
            }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .section-padding {
                padding: 4rem 0;
            }
            
            .hero-content {
                padding: 0 1rem;
            }
            
            .hero-title {
                font-size: clamp(1.8rem, 7vw, 2.8rem);
                margin-bottom: 1.2rem;
            }
            
            .hero-subtitle {
                font-size: clamp(0.95rem, 3.5vw, 1.2rem);
                margin-bottom: 2rem;
            }
            
            .credit-btn {
                padding: 0.8rem 2rem;
                font-size: 1rem;
            }
            
            .credits-carousel .credit-card {
                padding: 2.5rem 1.5rem;
                margin-bottom: 1.5rem;
            }
            
            .section-title {
                font-size: clamp(1.8rem, 5vw, 2.5rem);
                margin-bottom: 0.8rem;
            }
            
            .navbar-brand {
                font-size: 1.4rem;
            }
            
            .navbar {
                padding: 0.75rem 0;
            }
            
            .navbar.scrolled {
                padding: 0.5rem 0;
            }
        }
        
        @media (max-width: 576px) {
            .section-padding {
                padding: 3rem 0;
            }
            
            .hero-section {
                height: 100vh;
                min-height: 500px;
                margin-top: 70px;
                overflow: hidden;
            }
            
            .hero-content {
                padding: 0 1.5rem;
            }
            
            .hero-title {
                font-size: clamp(1.5rem, 8vw, 2.2rem);
                margin-bottom: 1rem;
            }
            
            .hero-subtitle {
                font-size: clamp(0.9rem, 4vw, 1.1rem);
                margin-bottom: 1.5rem;
                line-height: 1.5;
            }
            
            .credit-btn {
                padding: 0.7rem 1.8rem;
                font-size: 0.95rem;
            }
            
            .credits-carousel .credit-card {
                padding: 2rem 1.2rem;
            }
            
            .section-title {
                font-size: clamp(1.6rem, 6vw, 2.2rem);
            }
            
            .navbar-brand {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('partials.header')
    
    <main class="min-h-screen">
        @yield('content')
    </main>
    
    @include('partials.footer')
    
    <!-- Scripts essentiels -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    @stack('scripts')

<!-- Styles pour la boîte modale de code de suivi -->
<style>
.code-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    animation: fadeIn 0.3s ease-in-out;
}

.code-modal-container {
    background: linear-gradient(135deg, #ffffff 0%, #f8fff8 100%);
    border-radius: 16px;
    padding: 0;
    max-width: 500px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: slideIn 0.4s ease-out;
    border: 2px solid #10b981;
}

.code-modal-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 20px;
    text-align: center;
    border-radius: 14px 14px 0 0;
}

.success-icon {
    font-size: 3rem;
    margin-bottom: 10px;
    animation: pulse 2s infinite;
}

.code-modal-header h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.code-modal-body {
    padding: 30px;
}

.success-message {
    background: #f0fdf4;
    border-left: 4px solid #10b981;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    color: #065f46;
    font-weight: 500;
}

.code-display-section {
    text-align: center;
    margin: 25px 0;
}

.code-label {
    font-size: 1.1rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 10px;
}

.code-box {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 20px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 15px 0;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    position: relative;
}

.code-text {
    font-family: 'Courier New', monospace;
    font-size: 1.8rem;
    font-weight: bold;
    letter-spacing: 2px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.copy-btn {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 10px 15px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.copy-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
}

.copy-feedback {
    color: #10b981;
    font-weight: 600;
    margin-top: 10px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.copy-feedback.show {
    opacity: 1;
}

.instructions {
    background: #fef3c7;
    border: 1px solid #f59e0b;
    padding: 15px;
    border-radius: 8px;
    margin-top: 20px;
}

.instructions p {
    margin: 0;
    color: #92400e;
}

.code-modal-footer {
    padding: 20px 30px;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
    text-align: center;
    border-radius: 0 0 14px 14px;
}

.btn-confirmed {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1rem;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.btn-confirmed:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

/* Responsive */
@media (max-width: 640px) {
    .code-modal-container {
        width: 95%;
        margin: 10px;
        max-height: 95vh;
    }
    
    .code-modal-header {
        padding: 15px;
    }
    
    .code-modal-header h3 {
        font-size: 1.2rem;
    }
    
    .success-icon {
        font-size: 2.5rem;
    }
    
    .code-modal-body {
        padding: 15px;
    }
    
    .success-message {
        font-size: 0.9rem;
        padding: 12px;
    }
    
    .code-display-section {
        margin: 20px 0;
    }
    
    .code-label {
        font-size: 1rem;
        margin-bottom: 8px;
    }
    
    .code-box {
        padding: 15px;
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
    
    .code-text {
        font-size: 1.6rem;
        letter-spacing: 1px;
        word-break: break-all;
        line-height: 1.2;
    }
    
    .copy-btn {
        padding: 8px 20px;
        font-size: 0.9rem;
        align-self: center;
        min-width: 120px;
    }
    
    .copy-feedback {
        font-size: 0.85rem;
        margin-top: 8px;
    }
    
    .instructions {
        padding: 12px;
        margin-top: 15px;
    }
    
    .instructions p {
        font-size: 0.85rem;
    }
    
    .code-modal-footer {
        padding: 15px;
    }
    
    .btn-confirmed {
        padding: 10px 25px;
        font-size: 0.9rem;
        width: 100%;
        max-width: 200px;
    }
}

@media (max-width: 480px) {
    .code-text {
        font-size: 1.4rem;
        letter-spacing: 0.5px;
    }
    
    .code-modal-container {
        width: 98%;
        margin: 5px;
    }
    
    .code-modal-header {
        padding: 12px;
    }
    
    .code-modal-body {
        padding: 12px;
    }
    
    .success-icon {
        font-size: 2rem;
    }
    
    .code-box {
        padding: 12px;
    }
}

@media (max-width: 360px) {
    .code-text {
        font-size: 1.2rem;
        letter-spacing: 0;
    }
    
    .code-box {
        padding: 10px;
    }
    
    .copy-btn {
        padding: 6px 15px;
        font-size: 0.8rem;
        min-width: 100px;
    }
}
</style>

<!-- JavaScript pour la boîte modale -->
<script>
function closeCodeModal() {
    const modal = document.getElementById('codeModal');
    if (modal) {
        modal.style.animation = 'fadeOut 0.3s ease-out';
        setTimeout(() => {
            modal.remove();
        }, 300);
    }
}

function copyCode() {
    const codeText = document.querySelector('.code-text');
    if (codeText) {
        const code = codeText.textContent.trim();
        
        navigator.clipboard.writeText(code).then(() => {
            const feedback = document.getElementById('copyFeedback');
            if (feedback) {
                feedback.classList.add('show');
                setTimeout(() => {
                    feedback.classList.remove('show');
                }, 2000);
            }
        }).catch(() => {
            // Fallback pour navigateurs anciens
            const textArea = document.createElement('textarea');
            textArea.value = code;
            textArea.style.position = 'fixed';
            textArea.style.opacity = '0';
            document.body.appendChild(textArea);
            textArea.select();
            
            try {
                document.execCommand('copy');
                const feedback = document.getElementById('copyFeedback');
                if (feedback) {
                    feedback.classList.add('show');
                    setTimeout(() => {
                        feedback.classList.remove('show');
                    }, 2000);
                }
            } catch (err) {
                console.error('Erreur lors de la copie:', err);
            }
            
            document.body.removeChild(textArea);
        });
    }
}

// Fermer automatiquement après 30 secondes
setTimeout(() => {
    closeCodeModal();
}, 30000);

// Fermer avec la touche Escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeCodeModal();
    }
});
</script>

</body>
</html>
