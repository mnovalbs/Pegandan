<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndicatorStep extends Model
{
    protected $table = 'indicator_step';
    protected $primaryKey = 'id';
    protected $fillable = [
        'indicator_id',
        'label'
    ];

    public function indicator() 
    {
        return $this->belongsTo('App\Indicator', 'indicator_id');
    }
}
