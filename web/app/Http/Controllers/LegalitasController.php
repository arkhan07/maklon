<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalitasController extends Controller
{
    public function index()
    {
        return view('layanan.legalitas');
    }
}
