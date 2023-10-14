<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportSubmission;
use App\Models\User;
use App\Notifications\AssignedReport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        $user = auth()->user();
        $assignedReports = Report::where('assigned_user_id', $user->id);

        $reportQuery = Report::query();
        $reportQuery->where('name', 'like', '%'.request('q').'%');
        $reports = $reportQuery->paginate(25);
        
        return view('reports.index', compact('reports', 'assignedReports'));
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
        
        $imagePaths = [];
        
        // If there are no existing images, upload new ones
        foreach ($request->file('photo') as $v) {
            $fileName = time() . '_' . $v->getClientOriginalName();
            $path = $v->storeAs('images', $fileName, 'public');
            $imagePaths[] = '/storage/' . $path;
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

    public function getReportsByCategory($category)
    {
        $user = auth()->user();
        // Validate that the category is one of the allowed values (e.g., 'PENDING', 'INPROGRESS', etc.).
        $allowedCategories = ['PENDING', 'INPROGRESS', 'FINISHED', 'DECLINED', 'MY_REPORTS', 'ASSIGNED'];
    
        if (!in_array(strtoupper($category), $allowedCategories)) {
            abort(404); // Return a 404 response for invalid categories.
        }
    
        // If the category is "MY_REPORTS," retrieve reports created by the currently logged-in user.
        if (strtoupper($category) === "MY_REPORTS") {
            $reports = $user->reports; // Assuming you have a relationship set up.

            $count = $reports->count();
    
        // Create an associative array containing both reports and count.
        $data = [
            'reports' => $reports,
            'count' => $count,
            'user' => $user,
            ];
        }
        // If the category is "ASSIGNED," retrieve reports where user_id matches assigned_user_id.
        elseif (strtoupper($category) === "ASSIGNED") {
            $reports = Report::where('assigned_user_id', $user->id)->get();

            $count = $reports->count();
    
            // Create an associative array containing both reports and count.
            $data = [
                'reports' => $reports,
                'count' => $count,
                'user' => $user,
            ];
        } else {
            // Filter reports based on the selected category.
            $reports = Report::where('status', strtoupper($category))->get();

            $count = $reports->count();
    
            // Create an associative array containing both reports and count.
            $data = [
                'reports' => $reports,
                'count' => $count,
                'user' => $user,
            ];
        }
    
        return response()->json($data);
    }
    
    public function approveReport(Request $request, Report $report)
    {
        // Validate and authorize the request here, ensuring it's a City Engineer making the request
        $assignedUserId = $request->input('assignedUser');

        // Generate the URL of the report
        $reportUrl = $reportUrl = url(route('reports.show', ['report' => $report->id]));
        
        // Retrieve the creator user based on the report's creator_id
        $creatorUser = User::find($report->creator_id);

        // Generate the URL of the report
        $reportUrl = $reportUrl = url(route('reports.show', ['report' => $report->id]));

        // Update the report status to "Pending"
        $report->status = 'INPROGRESS';
    
        // Update the report to assign it to the selected user
        $report->assigned_user_id = $assignedUserId;
        $report->save();
        
        // Retrieve the user based on the assigned_user_id
        $assignedUser = User::find($assignedUserId);

        // Check if the user exists and has a name
        $userName = $assignedUser ? $assignedUser->name : 'Unknown User';

        // Pass the user's name to the notification
        User::find(Auth::user()->id)->notify(new AssignedReport($reportUrl, 'Assignment of Report '. $report->name .' to '. $userName .' was successful.'));

        // Send the notification to the assigned user
        Notification::send($assignedUser, new AssignedReport($reportUrl, 'Report '. $report->name .' was assigned to you.'));

        // Send the notification to the creator of the report
        Notification::send($creatorUser, new AssignedReport($reportUrl, 'Your report '. $report->name .' was approved'));

        // Send an SMS using Semaphore API
        $apiKey = 'de63e40d8c0adf3b5bf717105371af7f'; // Replace with your Semaphore API key
        $phoneNumber = $creatorUser->contact_number; // Replace with the recipient's phone number
        $message = 'Status of your report: "'. $report->name .'" was updated to INPROGRESS.' . ' See your report: ' . $reportUrl; // Adjust the message as needed
        $senderName = 'SEMAPHORE';

        $ch = curl_init();
        $parameters = [
            'apikey' => $apiKey,
            'number' => $phoneNumber,
            'message' => $message,
            'sendername' => $senderName,
        ];

        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/priority');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        curl_close($ch);

        return back();

    }

    public function markAsRead(){
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function declineReport(Request $request, Report $report)
    {
        // Generate the URL of the report
        $reportUrl = $reportUrl = url(route('reports.show', ['report' => $report->id]));
        $creatorUser = User::find($report->creator_id);

        $report->status = 'DECLINED';
        $report->decline_reason = $request->input('reason');

        $report->save();

        // Pass the user's name to the notification
        User::find(Auth::user()->id)->notify(new AssignedReport($reportUrl, 'Report '. $report->name .' to '. $userName .' was successfully declined.'));

        // Send the notification to the creator of the report
        Notification::send($creatorUser, new AssignedReport($reportUrl, 'Your report '. $report->name .' was declined'));

        // Send an SMS using Semaphore API
        $apiKey = 'de63e40d8c0adf3b5bf717105371af7f'; // Replace with your Semaphore API key
        $phoneNumber = $creatorUser->contact_number; // Replace with the recipient's phone number
        $message = 'Status of your report: "'. $report->name .'" was DECLINED.' . ' See your report: ' . $reportUrl; // Adjust the message as needed
        $senderName = 'SEMAPHORE';

        $ch = curl_init();
        $parameters = [
            'apikey' => $apiKey,
            'number' => $phoneNumber,
            'message' => $message,
            'sendername' => $senderName,
        ];

        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/priority');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        curl_close($ch);

        return back();
    }

    public function finishedReport(Request $request, Report $report)
    {
        // Generate the URL of the report
        $reportUrl = $reportUrl = url(route('reports.show', ['report' => $report->id]));
        $creatorUser = User::find($report->creator_id);
        
        // Validate and authorize the request here
        $request->validate([
            'finished_photo.*' => 'required|mimes:png,jpg,jpeg|max:2048', // Adjust validation rules as needed
        ]);

        $report->status = 'FINISHED';

        $imagePaths = [];

        foreach($request->file('finished_photo') as $v) {
            $fileName = time() . '_' . $v->getClientOriginalName();
            $path = $v->storeAs('images', $fileName, 'public');
            $imagePaths[] = '/storage/'.$path;
        }

        $report['finished_photo'] = json_encode($imagePaths);

        $report->save();

         // Send the notification to the creator of the report
         Notification::send($creatorUser, new AssignedReport($reportUrl, 'Your report '. $report->name .' was marked as Finished'));

        // Send an SMS using Semaphore API
        $apiKey = 'de63e40d8c0adf3b5bf717105371af7f'; // Replace with your Semaphore API key
        $phoneNumber = $creatorUser->contact_number; // Replace with the recipient's phone number
        $message = 'Status of your report: "'. $report->name .'" was marked as FINISHED.'; // Adjust the message as needed
        $senderName = 'SEMAPHORE';

        $ch = curl_init();
        $parameters = [
            'apikey' => $apiKey,
            'number' => $phoneNumber,
            'message' => $message,
            'sendername' => $senderName,
        ];

        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/priority');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        curl_close($ch);

        return back();
    }

    public function dashboard(Request $request)
    {
        // Set the timezone to "Asia/Manila"
        date_default_timezone_set('Asia/Manila');

        // Get the selected date range (you may need to adjust how this is obtained)
        $selectedDateRange = $request->input('date_range', 'all');

        // Calculate the start and end date based on the selected date range
        $startDate = null;
        $endDate = null;

        switch ($selectedDateRange) {
            case 'yesterday':
                $startDate = Carbon::yesterday()->startOfDay();
                $endDate = Carbon::yesterday()->endOfDay();
                break;
            case 'today':
                $startDate = Carbon::today()->startOfDay();
                $endDate = Carbon::today()->endOfDay();
                break;
            case 'last_7_days':
                $startDate = Carbon::now()->subDays(6)->startOfDay();
                $endDate = Carbon::now()->endOfDay();
                break;
            case 'last_30_days':
                $startDate = Carbon::now()->subDays(29)->startOfDay();
                $endDate = Carbon::now()->endOfDay();
                break;
            case 'last_90_days':
                $startDate = Carbon::now()->subDays(89)->startOfDay();
                $endDate = Carbon::now()->endOfDay();
                break;
            case 'all':
                // No date filtering, retrieve all reports
                break;
            default:
                // Handle invalid date range or set default values
                break;
        }

        // Initialize counts with default values
        $counts = [
            'PENDING' => 0,
            'INPROGRESS' => 0,
            'FINISHED' => 0,
            'DECLINED' => 0,
        ];

        // Query to retrieve reports based on date range and report status
        $query = DB::table('reports')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->whereIn('status', ['PENDING', 'INPROGRESS', 'FINISHED', 'DECLINED']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Retrieve counts from the database
        $dbCounts = $query
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Merge the retrieved counts with the initialized counts
        $counts = array_merge($counts, $dbCounts);

        // Return JSON response for the counts
        if ($request->expectsJson()) {
            return response()->json($counts);
        }
        
        // Retrieve data for the bar chart using a separate function
        $barChartData = $this->getBarChartData();

        // Retrieve data for the pie chart using a separate function
        $pieChartData = $this->getPieChartData();

        // Retrieve data for the index chart
        $totalReportCounts = $this->getReportCounts();

        // Return the view with data as variables
        return view('reports.dashboard', [
            'counts' => $counts,
            'selectedDateRange' => $selectedDateRange,
            'barChartData' => $barChartData,
            'pieChartData' => $pieChartData,
            'totalReportCounts' => $totalReportCounts,
        ]);
    }

    private function getBarChartData()
    {
        // Set the timezone to "Asia/Manila"
        date_default_timezone_set('Asia/Manila');

        // Retrieve data for the bar chart (modified logic)
        $reportCounts = DB::table('reports')
            ->selectRaw("DATE_FORMAT(created_at, '%M %e') as report_date, count(*) as count")
            ->groupBy('report_date')
            ->orderBy('report_date', 'desc')
            ->pluck('count', 'report_date')
            ->toArray();

        return [
            'reportCounts' => $reportCounts,
        ];
    }

    private function getPieChartData()
    {
        // Retrieve data for the pie chart (modified logic)
        $severityCounts = DB::table('reports')
            ->select('severity', DB::raw('count(*) as count'))
            ->groupBy('severity')
            ->pluck('count', 'severity')
            ->toArray();

        return $severityCounts;
    }

    private function getReportCounts()
    {
        $totalReports = Report::count();
        $assignedReports = Report::whereNotNull('assigned_user_id')->count();
        $urgentReports = Report::where('urgency', 'Urgent')->count();
        $nonUrgentReports = Report::where('urgency', 'Non-Urgent')->count();

        return [
            'totalReports' => $totalReports,
            'assignedReports' => $assignedReports,
            'urgentReports' => $urgentReports,
            'nonUrgentReports' => $nonUrgentReports,
        ];
    }
}
