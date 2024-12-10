<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Hardcoded Ngawi details
    private $originCity = '492'; // City ID for Ngawi
    private $originProvince = '35'; // Province ID for Jawa Timur

    /**
     * Display the cart for the logged-in user.
     */
    public function index()
    {
        // Mendapatkan item keranjang untuk user yang sedang login
        $cartItems = Keranjang::where('user_id', auth()->id())
                              ->with('produk') // Mengambil data produk terkait
                              ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('checkout.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Hitung total berat seluruh keranjang
        $totalWeight = $cartItems->sum(function ($item) {
            return $item->produk->berat * $item->quantity;
        });

        // Ambil daftar provinsi untuk keperluan form pengiriman
        $provinces = $this->getProvinces();

        return view('checkout.index', [
            'cartItems' => $cartItems,
            'totalWeight' => $totalWeight,
            'provinces' => $provinces,
            'originCity' => $this->originCity,
            'originProvince' => $this->originProvince,
        ]);
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        // Periksa apakah produk sudah ada di keranjang user
        $cartItem = Keranjang::where('produk_id', $id)
                             ->where('user_id', auth()->id())
                             ->first();

        if ($cartItem) {
            // Jika ada, tambahkan jumlahnya
            $cartItem->increment('quantity');
        } else {
            // Jika tidak ada, tambahkan sebagai item baru
            Keranjang::create([
                'user_id' => auth()->id(),
                'produk_id' => $id,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('checkout.index')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    /**
     * Remove a product from the cart.
     */
    public function remove($id)
    {
        // Menghapus item keranjang berdasarkan ID dan user ID
        $cartItem = Keranjang::where('produk_id', $id)
                             ->where('user_id', auth()->id())
                             ->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('checkout.index')->with('success', 'Produk berhasil dihapus');
        }

        return redirect()->route('checkout.index')->with('error', 'Produk tidak ditemukan');
    }

    public function getCities(Request $request)
    {
        $province_id = $request->province_id;
        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key')
        ])->get("https://api.rajaongkir.com/starter/city", [
            'province' => $province_id
        ]);

        return response()->json($response->json()['rajaongkir']['results']);
    }

    /**
     * Fetch available shipping services based on weight, province, city, and courier.
     */
    public function getShippingServices(Request $request)
{
    // Validate the request data
    $request->validate([
        'destination' => 'required|integer',
        'weight' => 'required|integer',
        'courier' => 'required|string',
    ]);

    $origin = $this->originCity; // City ID for Ngawi
    $destination = $request->destination;
    $weight = $request->weight;
    $courier = $request->courier;

    // Make API request to get shipping costs and services
    $response = Http::withHeaders([
        'key' => config('rajaongkir.api_key')
    ])->post('https://api.rajaongkir.com/starter/cost', [
        'origin' => $origin,
        'destination' => $destination,
        'weight' => $weight,
        'courier' => $courier,
    ]);

    $shippingServices = $response->json()['rajaongkir']['results'][0]['costs'];

    // Return shipping services as JSON to be handled by the JavaScript
    return response()->json($shippingServices);
}

    /**
     * Fetch the list of provinces from RajaOngkir API.
     */
    private function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key')
        ])->get('https://api.rajaongkir.com/starter/province');

        return $response->json()['rajaongkir']['results'];
    }
}
