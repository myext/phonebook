<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $hidden = [
        'updated_at',
        'created_at',
        'user_id'
    ];

    protected $fillable = [
        'number', 'user_id', 'is_mobile',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
