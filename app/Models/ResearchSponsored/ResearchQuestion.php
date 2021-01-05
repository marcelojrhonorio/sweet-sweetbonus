<?php

namespace App\Models\ResearchSponsored;

use Illuminate\Database\Eloquent\Model;

class ResearchQuestion extends Model
{
    protected $table = 'sweet_researches.researche_questions';

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
        'researches_id', 'questions_id', 'ordering',
    ];

}
