<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ContactUs;

class ContactUsController extends Controller
{
    public function submit(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $name = $validatedData['name'];
        $email = $validatedData['email'];
        $message = $validatedData['message'];
        
        $admin = User::role('Admin')->get();
        $engineerSupervisor = User::role('City Engineer Supervisor')->get();

        Notification::send($admin, new ContactUs($name, $email, $message));
        Notification::send($engineerSupervisor, new ContactUs($name, $email, $message));

        return back()->with('success', 'Message sent successfully');
    }
}
