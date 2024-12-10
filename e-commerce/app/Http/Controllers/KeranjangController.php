<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    /**
     * Display the cart for the logged-in user with product details and total weight.
     */
    public function index()
    {
        $cartItems = Keranjang::where('user_id', auth()->id())
                              ->with('produk') // Load related product data
                              ->get();

        // Add total weight (weight x quantity) for each item
        foreach ($cartItems as $item) {
            $item->total_berat = $item->produk->berat * $item->quantity;
        }

        // Calculate the total weight of the entire cart
        $totalWeight = $cartItems->sum('total_berat');

        return view('keranjang.index', compact('cartItems', 'totalWeight'));
    }

    /**
     * Add a product to the cart (similar to the 'keranjang' method in ProdukController).
     */
    public function add(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        // Check if the product is already in the cart for the current user
        $cartItem = Keranjang::where('produk_id', $id)
                             ->where('user_id', auth()->id())
                             ->first();

        if ($cartItem) {
            // If the product is already in the cart, increment the quantity
            $cartItem->increment('quantity');
        } else {
            // If the product is not in the cart, add it
            Keranjang::create([
                'user_id' => auth()->id(),
                'produk_id' => $id,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('keranjang.index')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    /**
     * Remove a product from the cart (like the 'destroy' method in ProdukController).
     */
    public function remove($id)
    {
        // Find and delete the cart item based on the product ID and user ID
        $cartItem = Keranjang::where('produk_id', $id)
                             ->where('user_id', auth()->id())
                             ->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('keranjang.index')->with('success', 'Produk berhasil dihapus dari keranjang');
        }

        return redirect()->route('keranjang.index')->with('error', 'Produk tidak ditemukan di keranjang');
    }
}
