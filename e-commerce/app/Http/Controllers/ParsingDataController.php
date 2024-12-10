<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ParsingDataController extends Controller
{
    public function parseData($nama_lengkap, $email, $jenis_kelamin)
    {
        $data = [
            'nama_lengkap' => $nama_lengkap,
            'email' => $email,
            'jenis_kelamin' => $jenis_kelamin
        ];

        return response()->json($data);
    }
}