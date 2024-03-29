<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patient';
    protected $primaryKey = 'id';
    protected $fillable = [
    	'name', 'birth_date', 'sex', 'kecamatan_id'
    ];

    public function getAgeAttribute()
    {
        $date_now = date_create(date("Y-m-d"));
        $date_birth = date_create($this->birth_date);

        $date_diff = date_diff($date_now, $date_birth);
        return $date_diff->format("%ythn %mbln");
    }

    public function kelurahan() 
    {
        return $this->belongsTo('App\Kelurahan', 'kelurahan_id');
    }

    public function history()
    {
        return $this->hasMany('App\Report', 'patient_id');
    }
}
