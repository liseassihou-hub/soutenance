<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>PEBCO - {{ $title ?? 'Authentification' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=open+sans:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
        
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, var(--bg-light) 0%, var(--bg-secondary) 100%);
            min-height: 100vh;
            color: var(--text-primary);
            line-height: 1.6;
        }
        
        .auth-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem 0;
            position: relative;
        }
        
        .auth-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(76, 175, 80, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(30, 94, 30, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .back-home-btn {
            position: fixed;
            top: 2rem;
            left: 2rem;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: var(--transition-base);
            display: inline-flex;
            align-items: center;
            z-index: 1000;
        }
        
        .back-home-btn:hover {
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 94, 30, 0.3);
        }
        
        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            background: white;
            position: relative;
            z-index: 5;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%);
            border: none;
            padding: 2rem;
            text-align: center;
        }
        
        .form-control {
            border: none;
            background: var(--bg-light);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-family: 'Open Sans', sans-serif;
            transition: var(--transition-base);
        }
        
        .form-control:focus {
            background: white;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
            border-color: var(--accent-green);
        }
        
        .input-group-text {
            border: none;
            background: var(--bg-light);
            border-radius: 8px 0 0 8px;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%);
            color: white;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 25px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: var(--transition-base);
            width: 100%;
        }
        
        .btn-primary-custom:hover {
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 94, 30, 0.3);
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            padding: 1rem;
        }
        
        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        .section-padding {
            padding: 2rem 0;
        }
        
        @media (max-width: 768px) {
            .back-home-btn {
                top: 1rem;
                left: 1rem;
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }
            
            .auth-container {
                padding: 1rem 0;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <a href="{{ route('home') }}" class="back-home-btn">
            <i class="fas fa-arrow-left me-2"></i>
            Retour à l'accueil
        </a>
        
        @yield('content')
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
