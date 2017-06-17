<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Band extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }
}
