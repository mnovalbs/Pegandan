<?php
namespace App\Http\Controllers;

use App\Indicator;
use Illuminate\Http\Request;

class IndicatorController extends Controller 
{
    public function view(Request $request)
    {
    	return view('indicator.index');
    }

    public function index(Request $request) 
    {
        $indikators = Indicator::with(['user', 'steps'])->get();
        
        return response()->api(200, $indikators);
    }
    
    public function show($id)
    {
        $indicator = Indicator::with(['user', 'steps', 'report'])->find($id);
        $responseCode = !empty($indicator) ? 200 : 404;

        foreach($indicator->report as $report) {
            $report->patient;
            $report->indicator;
            $report->steps;
        }
        
        return response()->api($responseCode, $indicator);
    }

    public function create(Request $request)
    {
        $name = $request->input('name');
        
        $indicator = new Indicator;
        $indicator->name = $name;
        $indicator->save();

        return response()->api(201, $indicator);
    }

    public function delete($id)
    {
        $indicator = Indicator::find($id);
        $indicator->delete();

        return response()->api(200, 'ok');
    }

    public function update(Request $request, $id)
    {
        $name = $request->input('name');
        
        $indicator = Indicator::find($id);
        $indicator->name = $name;
        $indicator->save();

        return response()->api(200, $indicator);
    }
}
?>