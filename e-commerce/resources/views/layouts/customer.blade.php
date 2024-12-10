<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ESTORE')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar {
            background: linear-gradient(90deg, #0056b3, #007bff);
        }
        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #ffbc00 !important;
            transform: scale(1.05);
            transition: 0.3s;
        }
        .container {
            max-width: 1200px;
            flex: 1; /* Memastikan container utama mengambil sisa ruang */
        }
        .footer {
            background-color: #212529;
            color: #ddd;
            padding: 15px 0;
            text-align: center;
            font-size: 12px;
        }
        .footer a {
            color: #ffbc00;
            text-decoration: none;
            font-weight: 500;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('https://via.placeholder.com/1600x600?text=Welcome+to+Toko+Online') no-repeat center center;
            background-size: cover;
            height: 400px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
        }
        .hero-section h1 {
            font-size: 48px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }
        .hero-section p {
            font-size: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.6);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('produk.indexPelanggan') }}">E'STORE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/homes') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('produk.indexPelanggan') }}">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/kontak-kami') }}">Kontak Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('keranjang.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        Keranjang
                        @php 
                            $cart = session()->get('keranjang', []);
                            $totalItems = count($cart);
                        @endphp
                        @if($totalItems > 0)
                            <span class="badge bg-danger">{{ $totalItems }}</span>
                        @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    @yield('hero')

    <!-- Main Content -->
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 E'STORE. All rights reserved.</p>
        <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>
</html>
