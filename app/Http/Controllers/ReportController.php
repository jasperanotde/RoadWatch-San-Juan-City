<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportSubmission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:report-list|report-create|report-edit|report-delete', ['only' => ['index','show']]);
         $this->middleware('permission:report-create', ['only' => ['create','store']]);
         $this->middleware('permission:report-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:report-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $this->authorize('manage_report');

        $reportQuery = Report::query();
        $reportQuery->where('name', 'like', '%'.request('q').'%');
        $reports = $reportQuery->paginate(25);

        return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new report.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new Report);

        return view('reports.create');
    }

    /**
     * Store a newly created Report in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Report);

        $newReport = $request->validate([
            'name'      => 'required|max:60',
            'address'   => 'nullable|max:255',
            'details'  => 'nullable|max:255',
            'photo' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'severity'  => 'nullable|max:255',
            'urgency'  => 'nullable|max:255',
            'status'  => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
        ]);

        // Set the "status" field to "Pending"
        $newReport['status'] = 'PENDING';

        $fileName = time().$request->file('photo')->getClientOriginalName();
        $path = $request->file('photo')->storeAs('images', $fileName, 'public'); 
        $newReport["photo"] = '/storage/'.$path;
        $newReport['creator_id'] = auth()->id();
        $report = Report::create($newReport);
        return redirect()->route('reports.show', $report);
    }

    /**
     * Display the specified report.
     *
     * @param  \App\report  $report
     * @return \Illuminate\View\View
     */
    public function show(Report $report)
    {
        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified report.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\View\View
     */
    public function edit(Report $report)
    {
        $this->authorize('update', $report);

        return view('reports.edit', compact('report'));
    }

    /**
     * Update the specified report in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Report $report)
    {
        $this->authorize('update', $report);

        $reportData = $request->validate([
            'name'      => 'required|max:60',
            'address'   => 'nullable|max:255',
            'details'  => 'nullable|max:255',
            'photo' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'severity'  => 'nullable|max:255',
            'urgency'  => 'nullable|max:255',
            'status'  => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',

        ]);
        
        $fileName = time().$request->file('photo')->getClientOriginalName();
        $path = $request->file('photo')->storeAs('images', $fileName, 'public'); 
        $reportData["photo"] = '/storage/'.$path;
        $reportData['creator_id'] = auth()->id();
        
        
        $report->update($reportData);

        return redirect()->route('reports.show', $report);
    }

    /**
     * Remove the specified report from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Report $report)
    {
        $this->authorize('delete', $report);

        $request->validate(['report_id' => 'required']);

        if ($request->get('report_id') == $report->id && $report->delete()) {
            return redirect()->route('reports.index');
        }

        return back();
    }
    
    // For Record Slip
    public function submit(Request $request, Report $report)
    {
        // Validate and save the submitted data for the report
        $request->validate([
            'new_field' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'materials' => 'required|string|max:255',
            'personnel' => 'required|string|max:255',
            'actions_taken.' => 'string|max:255', // Validate each action in the array
            'remarks' => 'nullable|string|max:255', // Remarks is optional
        ]);
    
        $report->submissions()->create([
            'new_field' => $request->input('new_field'),
            'date' => $request->input('date'),
            'location' => $request->input('location'),
            'materials' => $request->input('materials'),
            'personnel' => $request->input('personnel'),
            'actions_taken' => json_encode($request->input('actions_taken')), // Convert the selected checkboxes to a JSON string
            'remarks' => $request->input('remarks'),
        ]);

        return back();
    }

    public function deleteSubmissions(Request $request, Report $report)
    {
        $submissionId = $request->input('submission_id');
    
        // Find the specific submission associated with the report by its ID
        $submission = $report->submissions()->find($submissionId);
    
        if (!$submission) {
            return redirect()->route('route_name_for_show_page', ['report' => $report])
                ->with('error', 'Submission not found');
        }
    
        // Delete the found submission
        $submission->delete();

        return back()->with('success', 'Submissions for the report have been deleted successfully');
    }
    
}
