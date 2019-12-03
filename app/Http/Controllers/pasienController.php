<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasienController extends Controller
{
    //
    public function index(Request $request)
    {
    	if($request->has('cari')){
    		$data_pasien=\App\pasien::where('name', 'LIKE', '%'.$request->cari.'%')->get();
    	} else
    	{
    		$data_pasien = \App\pasien::all();
    	}
    	return view('pasien.index',['data_pasien'=>$data_pasien]);
    }

    public function create(Request $request)
    {
        \App\pasien::create($request->all());
        return redirect('/pasien')->with('sukses', 'Data pengguna berhasil ditambahkan.');
    }

    public function edit($id_pasien)
    {
        $pasien = \App\pasien::find($id_pasien);       
        return view('pasien/edit',['pasien'=>$pasien]);
    }

    public function update(Request $request, $id_pasien)
    {
        $pasien = \App\pasien::find($id_pasien);
        $pasien->update($request->all());
        return redirect('/pasien')->with('sukses', 'Data pengguna berhasil disunting');
    }

    public function delete ($id_pasien)
    {
        $pasien = \App\pasien::find($id_pasien);
        $pasien->delete($pasien);
        return redirect('/pasien')->with('sukses', 'Data pengguna berhasil dihapus.');
    }
}