<?php

namespace App\Http\Controllers\ResearchSponsored;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ResearchSponsored\MiddlePage;

class MiddlePageController extends Controller
{
    protected $model;
        
    public function __construct(MiddlePage $model)
    {
        $this->model = $model;
    }
}
