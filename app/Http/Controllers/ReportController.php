<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportSubmission;
use App\Models\User;
use App\Notifications\AssignedReport;
use App\Notifications\NewReports;
use App\Notifications\ApproveReport;
use App\Notifications\DeclineReport;
use App\Notifications\FinishReport;
use App\Notifications\ActionSlipReminder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $client;

    function __construct()
    {
         $this->middleware('permission:report-list|report-create|report-edit|report-delete', ['only' => ['index','show']]);
         $this->middleware('permission:report-create', ['only' => ['create','store']]);
         $this->middleware('permission:report-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:report-delete', ['only' => ['destroy','deleteSubmissions']]);

         $basic = new Basic("79521729", "5dvQMscp3QIYf1YI");
         $this->client = new Client($basic);
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

    
        // Retrieve the users with role of Admin and City Engineer Supervisor for notification
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Admin', 'City Engineer Supervisor']);
        })->get();
        

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

        // After creating the report
        $reportCreator = User::find($report->creator_id);
        // Now, you can access the creator's name
        $creatorName = $reportCreator->name;
        $reportName = $newReport['name']; // Get the report name
        $reportURL = url(route('reports.show', ['report' => $report->id]));

        Notification::send($users, new NewReports($reportName, $creatorName, $reportURL, "New Report created: '" . $reportName . "'. Created by: " . $creatorName));

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
        })
        ->leftJoin('reports', function ($join) {
            $join->on('users.id', '=', 'reports.assigned_user_id')
                 ->where('reports.status', '=', 'INPROGRESS');
        })
        ->select('users.id', 'users.name', DB::raw('COALESCE(COUNT(reports.id), 0) as report_count'))
        ->groupBy('users.id', 'users.name')
        ->get();
    

        $reportCreator = User::find($report->creator_id);
        $creatorName = $reportCreator->name;
        
        $startDate = Carbon::parse($report->startDate)->format('F d, Y');
        $targetDate = Carbon::parse($report->targetDate)->format('F d, Y');

        $startDateAction = null;
        $targetDateAction = null;

        foreach($report->submissions as $submission) {
            $startDateAction = Carbon::parse($submission->startDate)->format('F d, Y');
            $targetDateAction = Carbon::parse($submission->targetDate)->format('F d, Y');
        }

        return view('reports.show', compact('report', 'firstImageUrl', 'cityEngineers', 'creatorName', 'startDate', 'targetDate', 'startDateAction', 'targetDateAction'));
    }


    // For record slip
    public function submit(Request $request, Report $report)
    {
        // Validate and save the submitted data for the report
        $request->validate([
            'new_field' => 'required|string|max:255',
            'start-date-action' => 'required|date',
            'target-date-action' => 'required|date',
            'location' => 'required|string|max:255',
            'materials.*' => 'required|string|max:255',
            'personnel.*' => 'required|string|max:255',
            'actions_taken.' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
            'photo.*' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',

        ]);
    
        $report->submissions()->create([
            'new_field' => $request->input('new_field'),
            'startDate' => $request->input('start-date-action'),
            'targetDate' => $request->input('target-date-action'),
            'location' => $request->input('location'),
            'materials' => json_encode($request->input('materials')),
            'personnel' => json_encode($request->input('personnel')),
            'actions_taken' => json_encode($request->input('actions_taken')), // Convert the selected checkboxes to a JSON string
            'remarks' => '',
            'photo' => 'no image',
        ]);

        $assignedUser = User::find($report->assigned_user_id);
        
        foreach($report->submissions as $submission) {
            Notification::send($assignedUser, new ActionSlipReminder($report, $submission, $assignedUser));
        }

        return back();
    }

    public function updateSubmissions(Request $request, Report $report)
    {
        $submissionId = $request->input('submission_id');

        // Find the specific submission associated with the report by its ID
        $submission = $report->submissions()->find($submissionId);

        $request->validate([
            'actions_taken.' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
            'photo.*' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Update the 'actions_taken' field if provided
        if ($request->has('actions_taken')) {
            $submission->actions_taken = json_encode($request->input('actions_taken'));
        }
    
        // Update the 'remarks' field if provided
        if ($request->has('remarks')) {
            $submission->remarks = $request->input('remarks');
        }

        $imagePaths = [];
    
        // Update the 'photo' field if a new photo is provided
        if ($request->hasFile('photo')) {
            foreach($request->file('photo') as $v) {
                $fileName = time() . '_' . $v->getClientOriginalName();
                $path = $v->storeAs('images', $fileName, 'public');
                $imagePaths[] = '/storage/'.$path;
            }
        }

        $submission->photo = json_encode($imagePaths);
        $submission->is_updated = '1';
        
        $submission->save();

        return redirect()->back()->with('success', 'File uploaded successfully!');
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
            'photo.*' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'severity'  => 'nullable|max:255',
            'urgency'  => 'nullable|max:255',
            'status'  => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',

        ]);
        
        $imagePaths = [];

        // Check if the 'photo' key exists in $reportData
        if (array_key_exists('photo', $reportData)) {
            // Check if there are existing images
            if (is_null($reportData['photo'])) {
                if (!is_null($report->photo)) {
                    $imagePaths = json_decode($report->photo, true);
                }
            } else {
                foreach ($request->file('photo') as $v) {
                    $fileName = time() . '_' . $v->getClientOriginalName();
                    $path = $v->storeAs('images', $fileName, 'public');
                    $imagePaths[] = '/storage/' . $path;
                }
            }
            $reportData['photo'] = json_encode($imagePaths);
        }
        
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

        $request->validate([
            'start-date' => 'required',
            'target-date' => 'required',
        ], [
            'start-date.required' => 'The Start Date field is required.',
            'target-date.required' => 'The Target Date field is required.',
        ]);
        
        $assignedUserId = $request->input('assignedUser');
        $startDate = $request->input('start-date');
        $targetDate = $request->input('target-date');

        // Update the report status to "Pending"
        $report->status = 'INPROGRESS';
        $report->startDate = $startDate;
        $report->targetDate = $targetDate;
        $report->assigned_user_id = $assignedUserId;
        $report->save();

         // Generate the URL of the report
        $reportUrl = $reportUrl = url(route('reports.show', ['report' => $report->id]));
        // Retrieve the creator user based on the report's creator_id
        $creatorUser = User::find($report->creator_id);
        // Retrieve the user based on the assigned_user_id
        $assignedUser = User::find($assignedUserId);
        // Check if the user exists and has a name
        $userName = $assignedUser ? $assignedUser->name : 'Unknown User';
        // Pass the user's name to the notification
        $currentUserAuth = User::find(Auth::user()->id);

        // Send the Email Notification
        Notification::send($currentUserAuth, new AssignedReport($assignedUser, $currentUserAuth, $userName, $report->name, $reportUrl, 'Assignment of Report \''. $report->name .'\' to '. $userName .' was successful.'));
        Notification::send($assignedUser, new AssignedReport($assignedUser, $currentUserAuth, $userName, $report->name, $reportUrl, 'Report \''. $report->name .'\' was assigned to you.'));
        Notification::send($creatorUser, new ApproveReport($creatorUser->name, $report->name, $reportUrl, 'Your report \''. $report->name .'\' was Approved! See details.'));

        $this->smsNotif($creatorUser->contact_number, "Status of your Report: '" . $report->name . "' was marked as INPROGRESS. See report: " . $reportUrl);

        // SMS Notification
        // if ($this->smsNotif($creatorUser->contact_number, "Status of your Report: '" . $report->name . "' was marked as INPROGRESS. See report: " . $reportUrl)) {
        //     // SMS sent successfully
        //     $successMessage = 'SMS sent successfully.';
        // } else {
        //     // Handle SMS sending failure
        //     $failureMessage = 'Failed to send SMS. Please try again later.';
        // }
        // // Log the message, whether it's a success or failure
        // error_log(isset($successMessage) ? $successMessage : $failureMessage);

        return back();

    }

    public function markAsRead(){
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function declineReport(Request $request, Report $report)
    {
        $selectedDeclineReason = $request->input('decline_reason', []);
        $checkboxData = [];
    
        foreach ($selectedDeclineReason as $checkbox) {
            $checkboxData[$checkbox] = true;
        }

        $jsonData = json_encode($checkboxData);

        $report->status = 'DECLINED';
        $report->decline_reason = $jsonData;

        $report->save();

        // Generate the URL of the report
        $reportUrl = $reportUrl = url(route('reports.show', ['report' => $report->id]));
        $creatorUser = User::find($report->creator_id);
        $currentUserAuth = User::find(Auth::user()->id);

        Notification::send($currentUserAuth, new DeclineReport($currentUserAuth, $creatorUser, $creatorUser->name, $report->name, $reportUrl, 'Report \''. $report->name .'\' was successfully Declined.'));
        Notification::send($creatorUser, new DeclineReport($currentUserAuth, $creatorUser, $creatorUser->name, $report->name, $reportUrl, 'Your report \''. $report->name .'\' was Declined. See details.'));

        $this->smsNotif($creatorUser->contact_number, "Status of your Report: '" . $report->name . "' was DECLINED. See report: " . $reportUrl);

        // SMS Notification
        // if ($this->smsNotif($creatorUser->contact_number, "Status of your Report: '" . $report->name . "' was DECLINED. See report: " . $reportUrl)) {
        //     // SMS sent successfully
        //     $successMessage = 'SMS sent successfully.';
        // } else {
        //     // Handle SMS sending failure
        //     $failureMessage = 'Failed to send SMS. Please try again later.';
        // }
        // // Log the message, whether it's a success or failure
        // error_log(isset($successMessage) ? $successMessage : $failureMessage);
        
        return back();
    }

    public function finishedReport(Request $request, Report $report)
    {
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

        // Generate the URL of the report
        $reportUrl = $reportUrl = url(route('reports.show', ['report' => $report->id]));
        $creatorUser = User::find($report->creator_id);
        $currentUserAuth = User::find(Auth::user()->id);

        // Send the email notification
        Notification::send($currentUserAuth, new FinishReport($currentUserAuth, $creatorUser, $creatorUser->name, $report->name, $reportUrl, 'Report \''. $report->name .'\' was successfully tagged as Finished.'));
        Notification::send($creatorUser, new FinishReport($currentUserAuth, $creatorUser, $creatorUser->name, $report->name, $reportUrl, 'Your report \''. $report->name .'\' was tagged as Finished. See details'));

        $this->smsNotif($creatorUser->contact_number, "Status of your Report: '" . $report->name . "' was marked as FINISHED. See report: " . $reportUrl);

        // if ($this->smsNotif($creatorUser->contact_number, "Status of your Report: '" . $report->name . "' was marked as FINISHED. See report: " . $reportUrl)) {
        //     // SMS sent successfully
        //     $successMessage = 'SMS sent successfully.';
        // } else {
        //     // Handle SMS sending failure
        //     $failureMessage = 'Failed to send SMS. Please try again later.';
        // }
        // // Log the message, whether it's a success or failure
        // error_log(isset($successMessage) ? $successMessage : $failureMessage);  

        return back();
    }

    private function smsNotif($contactNumber, $messageContent) 
    {
        $response = $this->client->sms()->send(
            new \Vonage\SMS\Message\SMS($contactNumber, 'Vonage APIs', $messageContent)
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            return "The message was sent successfully\n";
        } else {
            return "The message failed with status: " . $message->getStatus() . "\n";
        }
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
            $query->whereBetween('updated_at', [$startDate, $endDate]);
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

        $totalReports = Report::count();

        // Return JSON response for the counts
        if ($request->expectsJson()) {
            return response()->json($totalReports);
        }

        
        // Return the view with data as variables
        return view('reports.dashboard', [
            'counts' => $counts,
            'selectedDateRange' => $selectedDateRange,
            'barChartData' => $barChartData,
            'pieChartData' => $pieChartData,
            'totalReportCounts' => $totalReportCounts,
            'totalReports' => $totalReports,
        ]);
    }

    private function getBarChartData()
    {
        // Set the timezone to "Asia/Manila"
        date_default_timezone_set('Asia/Manila');

        // Retrieve data for the bar chart (modified logic)
        $reportCounts = DB::table('reports')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') as report_date, count(*) as count")
            ->groupBy('report_date')
            ->orderBy('report_date', 'asc')
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
        // Set the timezone to "Asia/Manila"
        date_default_timezone_set('Asia/Manila');

        // Get the current date
        $currentDate = now()->format('Y-m-d');

        // Retrieve the count of reports before fetching the data
        $previousReportCount = Session::get('report_count_' . $currentDate, null);

        $previousAssignedReports = Session::get('assigned_reports_count_' . $currentDate, null);
        $previousUrgentReports = Session::get('urgent_reports_count_' . $currentDate, null);
        $previousNonUrgentReports = Session::get('non_urgent_reports_count_' . $currentDate, null);

        $currentReportCount = Session::get('report_count_' . $currentDate, 0);
        \Log::info("Current Report Count: $currentReportCount, Previous Report Count: $previousReportCount");

        $totalReports = Report::count();
        $assignedReports = Report::whereNotNull('assigned_user_id')->count();
        $urgentReports = Report::where('urgency', 'Urgent')->count();
        $nonUrgentReports = Report::where('urgency', 'Non-Urgent')->count();

        // Check if the count is not set or if it's different from the previous value
        $reportsAdded = $previousReportCount === null || $totalReports > $previousReportCount;

        // Check if the counts are not set or if they're different from the previous values
        $assignedReportsAdded = $previousAssignedReports === null || $assignedReports > $previousAssignedReports;
        $urgentReportsAdded = $previousUrgentReports === null || $urgentReports > $previousUrgentReports;
        $nonUrgentReportsAdded = $previousNonUrgentReports === null || $nonUrgentReports > $previousNonUrgentReports;

        // Set the counts in the session for the next comparison
        Session::put('report_count_' . $currentDate, $totalReports);
        Session::put('assigned_reports_count_' . $currentDate, $assignedReports);
        Session::put('urgent_reports_count_' . $currentDate, $urgentReports);
        Session::put('non_urgent_reports_count_' . $currentDate, $nonUrgentReports);

        \Log::info("Reports Added: " . ($reportsAdded ? 'Yes' : 'No'));
        \Log::info("Assigned Reports Added: " . ($assignedReportsAdded ? 'Yes' : 'No'));
        \Log::info("Urgent Reports Added: " . ($urgentReportsAdded ? 'Yes' : 'No'));
        \Log::info("Non-Urgent Reports Added: " . ($nonUrgentReportsAdded ? 'Yes' : 'No'));

        return [
            'totalReports' => $totalReports,
            'assignedReports' => $assignedReports,
            'urgentReports' => $urgentReports,
            'nonUrgentReports' => $nonUrgentReports,
            'reportsAdded' => $reportsAdded,
            'assignedReportsAdded' => $assignedReportsAdded,
            'urgentReportsAdded' => $urgentReportsAdded,
            'nonUrgentReportsAdded' => $nonUrgentReportsAdded,
        ];
    }

}
