<?php

namespace App\Models\ResearchSponsored;

use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    protected $table = 'sweet_researches.researches';

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    protected $fillable = [
        'title', 'subtitle', 'description', 'points', 'final_url', 'enabled',
    ];
}
