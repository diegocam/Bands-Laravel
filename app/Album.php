<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    /**
     * adds ability to Soft Delete https://laravel.com/docs/5.4/eloquent#soft-deleting
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * Defines relationship: each Album belongs to a Band
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function band()
    {
        return $this->belongsTo(Band::class);
    }
}
