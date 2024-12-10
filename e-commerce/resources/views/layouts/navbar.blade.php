<!-- resources/views/layouts/navbar.blade.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">E'Store</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left side navigation -->
            <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/kategori') }}">Kategori</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/produk') }}">Produk</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/transaksi') }}">Transaksi</a>
            </li>
            </ul>

            <!-- Right side: Logout Button -->
            <form action="{{ route('logout') }}" method="POST" class="d-flex ms-auto">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
</nav>
