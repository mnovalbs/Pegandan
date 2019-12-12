<?php
namespace App\Http\Controllers;

use App\Indicator;
use Illuminate\Http\Request;

class IndicatorController extends Controller 
{
    public function index(Request $request) 
    {
        $indikators = Indicator::with('user')->get();
        
        return response()->api(200, $indikators);
    }
    
    public function show($id)
    {
        $indicator = Indicator::with('user')->find($id);
        $responseCode = !empty($indicator) ? 200 : 404;
        
        return response()->api($responseCode, $indicator);
    }

    public function create(Request $request)
    {
        try {
            $name = $request->input('name');
            
            $indicator = new Indicator;
            $indicator->name = $name;
            $indicator->save();

            return response()->api(201, $indicator);
        } catch (Exception $e) {
            return abort(403, 'Error');
            return response()->api(400, array());
        }
    }
}
?>