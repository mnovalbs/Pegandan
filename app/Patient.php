<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patient';
    protected $primaryKey = 'id';
    protected $fillable = [
    	'name', 'birth_date', 'age', 'sex', 'state_id'
    ];
}


