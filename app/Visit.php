<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
        'geo' => 'array',
    ];

    public function link()
    {
        return $this->belongsTo('App\Link');
    }

    public function scopeOfLink($query, $link_id)
    {
        return $query->where('link_id', $link_id);
    }
}
