<?php
namespace App\Http\Controllers;

use App\IndicatorStep;
use Illuminate\Http\Request;

class IndicatorStepController extends Controller 
{
    public function list(Request $request)
    {
        $steps = IndicatorStep::with(['indicator'])->get();
        
        return response()->api(200, $steps);
    }

    public function create(Request $request)
    {
        $label = $request->input('label');
        $indicator_id = $request->input('indicator_id');
        
        $step = new IndicatorStep;
        $step->label = $label;
        $step->indicator_id = $indicator_id;
        $step->save();

        return response()->api(201, $step);
    }

    public function update(Request $request, $id)
    {
        $label = $request->input('label');
        
        $step = IndicatorStep::find($id);
        $step->label = $label;
        $step->save();

        return response()->api(201, $step);
    }

    public function delete($id)
    {
        $step = IndicatorStep::find($id);
        $step->delete();

        return response()->api(200, 'ok');
    }
}