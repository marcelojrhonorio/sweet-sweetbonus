<?php

namespace App\Models\ResearchSponsored;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'sweet_researches.options';

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
        'description',
    ];
}
