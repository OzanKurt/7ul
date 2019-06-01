<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Conner\Tagging\Taggable;

class Link extends Model
{
    use SoftDeletes;
    use Taggable;
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    public function visits()
    {
        return $this->hasMany('App\Visit');
    }


    public function scopeOfUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
}
