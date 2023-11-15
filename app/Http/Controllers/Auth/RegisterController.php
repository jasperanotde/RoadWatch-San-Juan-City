<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'contact_number' => [
                'required',
                'numeric',
                'phone'
            ],
        ]);
    }


    protected function messages()
{
    return [
        'contact_number.regex' => 'The contact number must start with 9 and have exactly 10 digits.',
    ];
}
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
    
    // Create the user
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'contact_number' => $data['contact_number'], 
        'password' => Hash::make($data['password']),
    ]);


    // Create the "Normal User" role
    $role = Role::firstOrCreate(['name' => 'Normal User']);

    // Find the necessary permissions
    $permissions = Permission::whereIn('name', [
        'report-list',
        'report-create',
        'report-edit',
        'report-delete',
    ])->get();

    // Assign the permissions to the role
    $role->syncPermissions($permissions);

    // Assign the role to the user
    $user->assignRole([$role->id]);

    return $user;
    }
}
