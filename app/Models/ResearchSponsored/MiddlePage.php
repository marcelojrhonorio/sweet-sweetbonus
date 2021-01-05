<?php

namespace App\Models\ResearchSponsored;

use Illuminate\Database\Eloquent\Model;

class MiddlePage extends Model
{
    protected $table = 'sweet_researches.middle_pages';

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
        'title', 'description', 'image_path', 'redirect_link',
    ];
    
}
