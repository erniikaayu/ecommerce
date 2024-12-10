<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di E'Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #74b9ff, #81ecec);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        nav {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 10;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.5rem;
            color: #2d3436;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            margin-right: 15px;
            color: #2d3436;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #0984e3;
        }

        .btn-nav {
            border-radius: 30px;
            padding: 8px 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .btn-login {
            background-color: #0984e3;
            color: white;
            border: none;
        }

        .btn-login:hover {
            background-color: #74b9ff;
        }

        .btn-register {
            border: 2px solid #0984e3;
            color: #0984e3;
            background-color: transparent;
        }

        .btn-register:hover {
            background-color: #0984e3;
            color: white;
        }

        .hero {
            margin-top: 90px;
            text-align: center;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: #2d3436;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .lead {
            font-size: 1.4rem;
            color: #636e72;
            margin-bottom: 30px;
        }

        footer {
            background-color: #2d3436;
            color: white;
            padding: 1rem 0;
            text-align: center;
            font-size: 0.85rem;
            margin-top: auto; /* Ensures footer stays at the bottom */
        }

        footer a {
            color: #74b9ff;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }

            .lead {
                font-size: 1.2rem;
            }

            .hero {
                margin-top: 15vh;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">E'Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <a href="{{ route('login') }}" class="btn btn-login btn-nav me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-register btn-nav">Register</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container hero">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Selamat Datang di E'Store</h1>
                <p class="lead">Temukan Berbagai Produk Menarik dan Nikmati Belanja Mudah!</p>
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-3">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Register</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>© 2024 E'Store. All rights reserved.</p>
        <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
