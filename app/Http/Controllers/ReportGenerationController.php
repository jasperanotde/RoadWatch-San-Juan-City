<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportGenerationController extends Controller
{
    public function generatePDF(Request $request)
    {
        $reports = Report::get();

        $data = [
            'title'     => 'Report Generation',
            'date'      => date('m/d/Y'),
            'reports'   => $reports
        ];

        $pdf = Pdf::loadview('reports.reportGen', $data);

        return $pdf->download('reports.pdf');
    }
}
