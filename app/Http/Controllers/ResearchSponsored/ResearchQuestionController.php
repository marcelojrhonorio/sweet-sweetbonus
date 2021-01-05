<?php

namespace App\Http\Controllers\ResearchSponsored;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ResearchSponsored\ResearchQuestion;

class ResearchQuestionController extends Controller
{
    protected $model;
        
    public function __construct(ResearcheQuestion $model)
    {
        $this->model = $model;
    }
}
