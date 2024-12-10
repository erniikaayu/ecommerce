<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Our Products</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
                <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                <p class="text-lg font-bold mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <form action="{{ route('checkout', $product->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input type="text" name="name" placeholder="Your Name" required
                            class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <input type="email" name="email" placeholder="Your Email" required
                            class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <input type="tel" name="phone" placeholder="Your Phone" required
                            class="w-full px-3 py-2 border rounded">
                    </div>
                    <button type="submit" 
                        class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Buy Now
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>