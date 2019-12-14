<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'report';
    protected $primaryKey = 'id';
    protected $fillable = [
    	'patient_id', 'indicator_id', 'status', 'reported_at'
    ];

    public function patient()
    {
        return $this->belongsTo('App\Patient', 'patient_id');
    }

    public function indicator()
    {
        return $this->belongsTo('App\Indicator', 'indicator_id');
    }

    public function steps()
    {
        return $this->hasMany('App\ReportStep', 'report_id');
    }
}
