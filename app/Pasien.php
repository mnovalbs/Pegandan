<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pasien extends Model
{
    protected $fillable = [
    	'nama_pasien', 'tanggal_lahir', 'usia', 'jenis_kelamin', 'id_kelurahan', 'id_indikator'
    ];
}


