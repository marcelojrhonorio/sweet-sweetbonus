<?php

namespace App\Http\Controllers\ShareAction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShareActionController extends Controller
{    
    public function index() {
        return view('share-action.redirect');
    }    
}
