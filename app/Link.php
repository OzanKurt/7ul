<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Conner\Tagging\Taggable;
use Reshadman\BijectiveShortener\BijectiveShortener;
use Hashids\Hashids;

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

    public function scopePublic($query)
    {
        return $query->where('private', 0);
    }

    public function encode($type = 'hashids')
    {
        if ($type == 'hashids') {
            $hashids  = new Hashids(config('7ul.hash-salt','7UpLink'));
            return $hashids->encode($this->id);
        } else if ( $type == 'bijective') {
            BijectiveShortener::setChars(
                config('7ul.characters','abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ')
            );
            return  BijectiveShortener::makeFromInteger($this->id);
        }
    }

    public function decode($type = 'hashids')
    {
        if ($type == 'hashids') {
            $hashids  = new Hashids(config('7ul.hash-salt','7UpLink'));
            return $hashids->decode($this->code);
        } else if ( $type == 'bijective') {
            BijectiveShortener::setChars(
                config('7ul.characters','abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ')
            );
            return BijectiveShortener::decodeToInteger($this->code);
        }
    }

    public function getLinkAttribute()
    {
        return "{$this->domain}{$this->code}";
    }

    public function getManageAttribute()
    {
        return "{$this->domain}manage/{$this->code}/{$this->password}";
    }
}
