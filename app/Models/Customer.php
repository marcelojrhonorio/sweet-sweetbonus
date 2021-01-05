<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [
        'id',
        'points',
        'confirmed',
        'resend_attempts',
        'created_at',
        'update_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the checkins for the customer.
     */
    public function checkins()
    {
        return $this->hasMany('App\Models\Checkin');
    }    
}
