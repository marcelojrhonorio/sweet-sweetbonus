<?php

namespace App\Models\ResearchSponsored;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'sweet_researches.questions';

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
        'description', 'one_answer', 'extra_information',
    ];
}
