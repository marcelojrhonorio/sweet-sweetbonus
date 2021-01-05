<?php

namespace App\Models\ResearchSponsored;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $table = 'sweet_researches.question_options';

    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'questions_id', 'options_id',
    ];
}
