<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    protected $table = 'indicator';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];

    public function user() 
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function steps()
    {
        return $this->hasMany('App\IndicatorStep', 'indicator_id');
    }
}
