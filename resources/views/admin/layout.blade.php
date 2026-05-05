<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PEBCO')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 0;
            transition: margin-left 0.3s ease;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }

        .btn {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .nav-link {
            color: var(--dark-color);
            border-radius: 10px;
            transition: all 0.3s ease;
            margin-bottom: 5px;
        }

        .nav-link:hover {
            background: var(--primary-color);
            color: white;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: var(--primary-color);
            color: white;
        }

        .sidebar {
            position: fixed;
            top: 80px;
            left: 0;
            width: 250px;
            height: calc(100vh - 80px);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .main-content {
            margin-left: 250px;
            min-height: calc(100vh - 80px);
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .sidebar-collapsed {
            transform: translateX(-250px);
        }

        .sidebar-collapsed + .main-content {
            margin-left: 0;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }
            
            .main-content {
                margin-left: 0;
                padding: 10px;
            }
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    @yield('content')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>
