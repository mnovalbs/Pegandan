<?php
namespace App\Http\Controllers;

use App\Kelurahan;
use Illuminate\Http\Request;

class KelurahanController extends Controller 
{
    public function view(Request $request)
    {
    	return view('kelurahan.index');
    }

    public function index(Request $request) 
    {
        $kelurahan = Kelurahan::with(['patient'])->get();
        
        return response()->api(200, $kelurahan);
    }

    public function create(Request $request)
    {
        $name = $request->input('name');
        
        $kelurahan = new Kelurahan;
        $kelurahan->name = $name;
        $kelurahan->save();

        return response()->api(201, $kelurahan);
    }

    public function delete($id)
    {
        $kelurahan = Kelurahan::find($id);
        $kelurahan->delete();

        return response()->api(200, 'ok');
    }

    public function update(Request $request, $id)
    {
        $name = $request->input('name');
        
        $kelurahan = Kelurahan::find($id);
        $kelurahan->name = $name;
        $kelurahan->save();

        return response()->api(200, $kelurahan);
    }
}
?>