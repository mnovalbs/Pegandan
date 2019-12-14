<?php

namespace App\Http\Controllers;

use \App\Report;
use \App\IndicatorStep;
use \App\ReportStep;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function view()
    {
        return view('report.index');
    }

    public function list(Request $request)
    {
        $reports = Report::with(['steps', 'patient', 'indicator'])->get();
        return response()->api(200, $reports);
    }

    public function create(Request $request)
    {
        $patient_id = $request->input('patient_id');
        $indicator_id = $request->input('indicator_id');
        $reported_at = $request->input('reported_at');
        $steps_id = $request->input('steps_id');

        $steps = $this->generate_steps_status($indicator_id, $steps_id);

        $report = new Report;
        $report->patient_id = (int)$patient_id;
        $report->indicator_id = (int)$indicator_id;
        $report->status = $steps['status'];
        $report->reported_at = $reported_at;
        $report->save();

        foreach($steps['steps'] as $step)
        {
            $report_step = new ReportStep;
            $report_step->report_id = $report->id;
            $report_step->indicator_step_id = $step['id'];
            $report_step->status = $step['status'];
            $report_step->save();
        }

        $report->steps = $steps['steps'];

        return response()->api(201, $report);
    }

    public function delete($id)
    {
        $indicator = Report::find($id);
        $indicator->delete();

        return response()->api(200, 'ok');
    }

    private function generate_steps_status($indicator_id, $steps_id = [])
    {
        $steps = [];
        $status = true;
        $indicator_step = IndicatorStep::where('indicator_id', $indicator_id)->get();

        foreach($indicator_step as $step)
        {
            $is_checked = in_array($step->id, $steps_id);
            $status = $status && $is_checked;
            $new_step = [
                'id' => $step->id,
                'label' => $step->label,
                'status' => $is_checked
            ];
            array_push($steps, $new_step);
        }

        return [
            'status' => $status,
            'steps' => $steps
        ];
    }
}