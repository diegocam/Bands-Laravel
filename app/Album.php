<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function band()
    {
        return $this->belongsTo(Band::class);
    }
}
