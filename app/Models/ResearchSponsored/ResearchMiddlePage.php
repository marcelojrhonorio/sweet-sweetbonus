<?php

namespace App\Models\ResearchSponsored;

use Illuminate\Database\Eloquent\Model;

class ResearchMiddlePage extends Model
{
    protected $table = 'sweet_researches.researches_middle_pages';

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
        'researches_id', 'researches_id', 'middle_pages_id', 'options_id', 'questions_id'
    ];
}
