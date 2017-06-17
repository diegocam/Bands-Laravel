<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Band extends Model
{
    /**
     * adds ability to Soft Delete https://laravel.com/docs/5.4/eloquent#soft-deleting
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * Defines relationship: each Band has many Album(s)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function albums()
    {
        return $this->hasMany(Album::class);
    }
}
