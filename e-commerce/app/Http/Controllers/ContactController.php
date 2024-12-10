<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Menampilkan halaman kontak kami
    public function index()
    {
        return view('pages.contact');
    }
}
