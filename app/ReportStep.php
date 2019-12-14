<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportStep extends Model
{
    protected $table = 'report_step';
    protected $primaryKey = 'id';
    protected $fillable = [
    	'report_id', 'indicator_step_id', 'status'
    ];
}
