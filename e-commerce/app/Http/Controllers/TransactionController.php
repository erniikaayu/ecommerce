<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration once
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function checkout(Request $request)
    {
        // Validasi input pengguna
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
        ]);

        // Ambil semua item keranjang untuk pengguna yang sedang login
        $cartItems = Keranjang::where('user_id', auth()->id())
            ->with('produk')
            ->get();

        // Cek jika keranjang kosong
        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong');
        }

        // Hitung total harga
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->produk->harga * $item->quantity;
        });

        // Buat order ID menggunakan UUID
        $orderId = 'ORDER-' . \Str::uuid();

        // Sisipkan data transaksi ke dalam tabel `transactions`
        $transaction = Transaction::create([
            'transaction_id' => mt_rand(100000, 999999),
            'order_id' => $orderId,
            'gross_amount' => $totalAmount,
            'transaction_time' => now(),
            'transaction_status' => 'pending',
            'metadata' => [
                'user_id' => auth()->id(),
                'cart_items' => $cartItems->pluck('produk.nama')->toArray(),
            ],
        ]);

        // Sisipkan data ke dalam tabel `transaksi`
        $transaksi = Transaksi::create([
            'pelanggan_id' => auth()->id(),  // Mengambil ID pelanggan yang sedang login
            'total_harga' => $totalAmount,
            'produk_id' => $cartItems->first()->produk_id,  // Asumsikan satu produk per transaksi, sesuaikan jika ada lebih dari satu
            'deskripsi' => 'Pembelian produk dari keranjang',
            'nomor_invoice' => $orderId,
            'status_pembayaran' => 'succes',
            'tanggal_pembelian' => now(),
        ]);

        // Persiapkan parameter untuk pembayaran Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalAmount,
            ],
            'customer_details' => [
                'first_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ],
        ];

        try {
            // Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);
            return view('checkout', compact('snapToken', 'cartItems', 'totalAmount'));
        } catch (\Exception $e) {
            \Log::error('Midtrans Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi nanti.');
        }
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed === $request->signature_key) {
            $transaction = Transaction::where('order_id', $request->order_id)->first();

            if ($transaction) {
                // Update transaction status
                $transaction->update(['transaction_status' => $request->transaction_status]);

                if ($request->transaction_status === 'settlement') {
                    $transaction->update(['transaction_status' => 'settlement']);
                } elseif ($request->transaction_status === 'capture') {
                    $transaction->update(['transaction_status' => 'paid']);
                } elseif ($request->transaction_status === 'cancel') {
                  $transaction->update(['transaction_status' => 'cancelled']);
            }

            }
        }

        return response()->json(['message' => 'Callback processed successfully']);
    }
}
