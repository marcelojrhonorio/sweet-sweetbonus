<?php

namespace App\Http\Controllers\ResearchSponsored;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ResearchSponsored\QuestionOption;

class QuestionOptionController extends Controller
{
    protected $model;
        
    public function __construct(QuestionOption $model)
    {
        $this->model = $model;
    }
}
