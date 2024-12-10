<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OngkirController extends Controller
{
    // Hardcoded Ngawi details
    private $originCity = '492'; // City ID for Ngawi
    private $originProvince = '35'; // Province ID for Jawa Timur

    public function index()
    {
        // Ambil daftar provinsi
        $provinces = $this->getProvinces();
        
        // Pass the hardcoded origin details to the view
        return view('pages.ongkir.index', [
            'provinces' => $provinces,
            'originCity' => $this->originCity,
            'originProvince' => $this->originProvince
        ]);
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

    public function checkOngkir(Request $request)
    {
        $origin = $this->originCity; // Use hardcoded Ngawi city
        $destination = $request->destination;
        $weight = $request->weight;
        $courier = $request->courier;

        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key')
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier
        ]);

        $results = $response->json()['rajaongkir']['results'][0]['costs'];
        
        return view('pages.ongkir.result', compact('results'));
    }

    private function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key')
        ])->get('https://api.rajaongkir.com/starter/province');

        return $response->json()['rajaongkir']['results'];
    }
}