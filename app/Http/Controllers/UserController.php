<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Report;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
    
class UserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        // Initialize an array to store roles that should be visible to the current user
        $visibleRoles = [];

        // Check if the currently logged-in user has the "City Engineer Supervisor" role
        if (auth()->user() && auth()->user()->hasRole('City Engineer Supervisor')) {
            // If the user is a "City Engineer Supervisor," add the "City Engineer" role to the visible roles
            $visibleRoles[] = 'City Engineer';
        }

        // Check if the currently logged-in user has the "Admin" role
        if (auth()->user() && auth()->user()->hasRole('Admin')) {
            // If the user is an "Admin," allow them to see all roles
            $visibleRoles = Role::pluck('name')->all();
        }

        $data = User::role($visibleRoles)->orderBy('id', 'DESC')->paginate(5);

        // Initialize empty arrays to store roles and userRoles
        $roles = Role::pluck('name', 'name')->all();
        $userRole = [];

        foreach ($data as $user) {
            // Retrieve roles for each user and add them to the $userRole array
            $userRole[$user->id] = $user->getRoleNames()->first();
        }

        return view('users.index', compact('data', 'roles', 'userRole'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'phone_number' => 'required',

        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $roleNames = Role::pluck('name','name')->all();
        $userRole = $user->role;

        return view('users.edit',compact('user','roleNames','userRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|same:confirm-password',
            'contact_number' => 'nullable',
            'roles' => 'nullable',
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
{
    // Find the user
    $user = User::find($id);

    if (!$user) {
        return redirect()->route('users.index')->with('error', 'User not found');
    }

    // Get the reports created by the user
    $reports = $user->reports;

    // Delete the reports associated with the user
    foreach ($reports as $report) {
        $report->delete();
    }

    // Delete the user
    $user->delete();

    return redirect()->route('users.index')->with('success', 'User and associated reports deleted successfully');
}

}