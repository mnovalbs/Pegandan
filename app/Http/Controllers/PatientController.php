<?php

namespace App\Http\Controllers;

use \App\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    //
    public function index(Request $request)
    {
    	if($request->has('cari')){
    		$data_pasien = Patient::where('name', 'LIKE', '%'.$request->cari.'%')->get();
    	} else
    	{
    		$data_pasien = Patient::all();
    	}
    	return view('pasien.index',['data_pasien'=>$data_pasien]);
    }

    public function create(Request $request)
    {
        Patient::create($request->all());
        return redirect('/pasien')->with('sukses', 'Data pengguna berhasil ditambahkan.');
    }

    public function edit($id_pasien)
    {
        $pasien = Patient::find($id_pasien);       
        return view('pasien/edit',['pasien'=>$pasien]);
    }

    public function update(Request $request, $id_pasien)
    {
        $pasien = Patient::find($id_pasien);
        $pasien->update($request->all());
        return redirect('/pasien')->with('sukses', 'Data pengguna berhasil disunting');
    }

    public function delete ($id_pasien)
    {
        $pasien = Patient::find($id_pasien);
        $pasien->delete($pasien);
        return redirect('/pasien')->with('sukses', 'Data pengguna berhasil dihapus.');
    }

    public function apiList()
    {
        $patients = Patient::with(['kelurahan'])->get();
        foreach ($patients as $patient) {
            $patient->age = $patient->age;
        }
        return response()->api(200, $patients);
    }

    public function apiCreate(Request $request)
    {
        $name = $request->input('name');
        $birth_date = $request->input('birth_date');
        $sex = $request->input('sex');
        $kelurahan_id = $request->input('kelurahan_id');

        $patient = new Patient;
        $patient->name = $name;
        $patient->birth_date = $birth_date;
        $patient->sex = $sex;
        $patient->kelurahan_id = $kelurahan_id;
        $patient->save();

        return response()->api(201, $patient);
    }

    public function apiUpdate(Request $request, $id)
    {
        $name = $request->input('name');
        $birth_date = $request->input('birth_date');
        $sex = $request->input('sex');
        $kelurahan_id = $request->input('kelurahan_id');

        $patient = Patient::find($id);
        $patient->name = $name;
        $patient->birth_date = $birth_date;
        $patient->sex = $sex;
        $patient->kelurahan_id = $kelurahan_id;
        $patient->save();

        return response()->api(201, $patient);
    }

    public function apiDetail(Request $request, $id)
    {
        $patient = Patient::with(['history'])->find($id);

        foreach($patient->history as $history)
        {
            $history->indicator;
            $history->steps;
        }

        return response()->api(200, $patient);
    }
}