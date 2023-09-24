<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportSubmission;
use App\Models\User;
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
         $this->middleware('permission:report-delete', ['only' => ['destroy','deleteSubmissions']]);
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
            'photo.*' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'severity'  => 'nullable|max:255',
            'urgency'  => 'nullable|max:255',
            'status'  => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
        ]);

        // Set the "status" field to "Pending"
        $newReport['status'] = 'PENDING';

        $imagePaths = [];

        foreach($request->file('photo') as $v) {
            $fileName = time() . '_' . $v->getClientOriginalName();
            $path = $v->storeAs('images', $fileName, 'public');
            $imagePaths[] = '/storage/'.$path;
        }

        $newReport['photo'] = json_encode($imagePaths);

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
        // Assuming $report->photo contains a JSON-encoded array of image URLs
        $imageUrls = json_decode($report->photo);

        // Get the first image URL or set a default value if no images are available
        $firstImageUrl = !empty($imageUrls) ? $imageUrls[0] : 'default-image-url.jpg';

        $cityEngineers = User::whereHas('roles', function ($query) {
            $query->where('name', 'City Engineer');
        })->get();

        return view('reports.show', compact('report', 'firstImageUrl', 'cityEngineers'));
    }


    //para sa record slip
    public function submit(Request $request, Report $report)
    {
        // Validate and save the submitted data for the report
        $request->validate([
            'new_field' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'materials.*' => 'required|string|max:255',
            'personnel.*' => 'required|string|max:255',
            'actions_taken.' => 'string|max:255', // Validate each action in the array
            'remarks' => 'nullable|string|max:255', // remarks is optional
        ]);
    
        $report->submissions()->create([
            'new_field' => $request->input('new_field'),
            'date' => $request->input('date'),
            'location' => $request->input('location'),
            'materials' => json_encode($request->input('materials')),
            'personnel' => json_encode($request->input('personnel')),
            'actions_taken' => json_encode($request->input('actions_taken')), // Convert the selected checkboxes to a JSON string
            'remarks' => $request->input('remarks'),
        ]);

    
        return back();
    }

    public function deleteSubmissions(Request $request, Report $report)
    {
        $this->authorize('delete', $report);

        $submissionId = $request->input('submission_id');

        // Find the specific submission associated with the report by its ID
        $submission = $report->submissions()->find($submissionId);

        if (!$submission) {
            return redirect()->route('reports.show',['report' => $report])
                ->with('error', 'Submission not found');
        }

        // Delete the found submission
        $submission->delete();
        
        return back()->with('success', 'Submissions for the report have been deleted successfully');
    }

    /**
     * Show the form for editing the specified report.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\View\View
     */
    public function edit(Report $report)
    {      
         // Assuming $report->photo contains a JSON-encoded array of image URLs
         $imageUrls = json_decode($report->photo);

         // Get the first image URL or set a default value if no images are available
         $firstImageUrl = !empty($imageUrls) ? $imageUrls[0] : 'default-image-url.jpg';
        $this->authorize('update', $report);

        return view('reports.edit', compact('report','firstImageUrl'));
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
            'photo.*' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'severity'  => 'nullable|max:255',
            'urgency'  => 'nullable|max:255',
            'status'  => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',

        ]);
        
        // Set the "status" field to "Pending"
        $reportData['status'] = 'PENDING';

        $imagePaths = [];
        
        // Check if there are existing images
        if (!is_null($report->photo)) {
            // If there are existing images, use them
            $imagePaths = json_decode($report->photo, true);
        } else {
            // If there are no existing images, upload new ones
            foreach ($request->file('photo') as $v) {
                $fileName = time() . '_' . $v->getClientOriginalName();
                $path = $v->storeAs('images', $fileName, 'public');
                $imagePaths[] = '/storage/' . $path;
            }
        }

        $reportData['photo'] = json_encode($imagePaths);
        
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
    
    public function approveReport(Request $request, Report $report)
    {
        // Validate and authorize the request here, ensuring it's a City Engineer making the request
    
        $assignedUserId = $request->input('assignedUser');

        // Update the report status to "Pending"
        $report->status = 'INPROGRESS';
    
        // Update the report to assign it to the selected user
        $report->assigned_user_id = $assignedUserId;
        $report->save();
    
        return back();
    }

    public function declineReport(Request $request, Report $report)
    {
        // Validate and authorize the request here

        $report->status = 'DECLINED';
        $report->save();

        return back();
    }

}
