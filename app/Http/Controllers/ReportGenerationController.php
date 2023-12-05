<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use App\Models\ReportSubmission;
use App\Models\ReportSubmissionUpdate;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportGenerationController extends Controller
{
    public function generatePDF(Request $request)
    {
        // Retrieve users with the "City Engineer" role
        $cityEngineerRole = 'City Engineer';

        $usersWithCityEngineerRole = User::whereHas('roles', function ($query) use ($cityEngineerRole) {
            $query->where('name', $cityEngineerRole);
        })->get();
        
        $userIds = $usersWithCityEngineerRole->pluck('id')->toArray();
        $reports = Report::whereIn('assigned_user_id', $userIds)->get();

        $data = [
            'title'     => 'Report Generation',
            'date'      => date('m/d/Y'),
            'reports'   => $reports,
            'cityEngineers' => $usersWithCityEngineerRole
        ];

        $pdf = Pdf::loadview('reports.reportGen', $data);

        return $pdf->download('reports.pdf');
    }
}
