<?php

namespace App\Http\Controllers;

use \App\Report;
use \App\Indicator;
use \App\IndicatorStep;
use \App\ReportStep;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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

        $this->update_report_step($report->id, $steps['steps']);

        $report->steps = $steps['steps'];

        return response()->api(201, $report);
    }

    public function update(Request $request, $report_id)
    {
        $report = Report::find($report_id);
        $steps_id = $request->input('steps_id');

        $steps = $this->generate_steps_status($report->indicator_id, $steps_id);

        # update report
        $report->status = $steps['status'];
        $report->save();

        $this->update_report_step($report->id, $steps['steps'], true);

        $report->steps = $steps['steps'];

        return response()->api(201, $report);
    }

    public function indicators(Request $request)
    {
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');

        $indicators = Indicator::get();
        $reports = [];

        foreach($indicators as $indicator)
        {
            $report = $this->indicator_report($indicator->id, $date_start, $date_end);
            array_push($reports, [
                'name' => $indicator->name,
                'report' => $report
            ]);
        }

        return response()->api(200, $reports);
    }

    public function indicators_download(Request $request)
    {
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');

        $indicators = Indicator::get();
        $reports = [];

        foreach($indicators as $indicator)
        {
            $report = $this->indicator_report($indicator->id, $date_start, $date_end);
            array_push($reports, [
                $indicator->name,
                $report['complete'] === 0 ? '0' : $report['complete'],
                $report['incomplete'] === 0 ? '0' : $report['incomplete'],
                $report['complete'] === 0 ? '0' : $report['percentage'] * 100
            ]);
        }

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->fromArray(['Indicator', 'Status', '', 'Percentage'], NULL, 'A1');
        $spreadsheet->getActiveSheet()->fromArray(['', 'Complete', 'Incomplete'], NULL, 'A2');
        $spreadsheet->getActiveSheet()->mergeCells('A1:A2');
        $spreadsheet->getActiveSheet()->mergeCells('B1:C1');
        $spreadsheet->getActiveSheet()->mergeCells('D1:D2');
        $spreadsheet->getActiveSheet()->fromArray($reports, NULL, 'A3');

        $date = Date("Y-m-d H-m-s");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $date_start . '_' . $date_end . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function delete($id)
    {
        $indicator = Report::find($id);
        $indicator->delete();

        return response()->api(200, 'ok');
    }

    private function indicator_report($indicator_id, $date_start, $date_end)
    {
        $complete = Report::where('indicator_id', $indicator_id)
                          ->where('reported_at', '<=', $date_end)
                          ->where('reported_at', '>=', $date_start)
                          ->where('status', 1)
                          ->count();
        
        $in_complete = Report::where('indicator_id', $indicator_id)
                             ->where('reported_at', '<=', $date_end)
                             ->where('reported_at', '>=', $date_start)
                             ->where('status', 0)
                             ->count();

        $total = $complete + $in_complete;
        
        return [
            'complete' => $complete,
            'incomplete' => $in_complete,
            'percentage' => $total !== 0 ? $complete / ( $complete + $in_complete ) : 0
        ];
    }

    private function report_step_exists($report_id, $indicator_step_id)
    {
        $report_step = ReportStep::where('report_id', $report_id)
                                 ->where('indicator_step_id', $indicator_step_id);

        return $report_step;
    }

    private function remove_report_step($report_step)
    {
        if (!empty($report_step))
        {
            $report_step->delete();
        }
    }

    private function update_report_step($report_id, $steps, $is_edit = false)
    {
        foreach($steps as $step)
        {
            if ($is_edit)
            {
                $exists_report_step = $this->report_step_exists($report_id, $step['id']);
                $this->remove_report_step($exists_report_step);
            }

            $report_step = new ReportStep;
            $report_step->report_id = $report_id;
            $report_step->indicator_step_id = $step['id'];
            $report_step->status = $step['status'];
            $report_step->save();
        }
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