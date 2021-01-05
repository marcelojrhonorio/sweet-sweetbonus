<?php

namespace App\Http\Controllers\ResearchSponsored;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ResearchSponsored\ResearchMiddlePage;

class ResearchMiddlePageController extends Controller
{
    protected $model;
        
    public function __construct(Question $model)
    {
        $this->model = $model;
    }
}
