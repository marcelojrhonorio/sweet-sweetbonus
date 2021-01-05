<?php

namespace App\Http\Controllers\ResearchSponsored;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ResearchSponsored\Option;

class OptionController extends Controller
{
    protected $model;
        
    public function __construct(Option $model)
    {
        $this->model = $model;
    }
}
