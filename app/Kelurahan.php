<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'kelurahan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];

    public function patient()
    {
        return $this->hasMany('App\Patient', 'kelurahan_id');
    }
}
