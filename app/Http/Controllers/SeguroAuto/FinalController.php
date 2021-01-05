<?php

namespace App\Http\Controllers\SeguroAuto;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FinalController extends Controller
{
    public function index()
    {
        //return view('seguro-auto.final');
        return view('seguro-auto.banners');
    }
}
