@extends('layout.layout')

@section('content')
<div class="w-full max-w-sm mx-auto my-28 overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
    <div class="px-6 py-4">
        <div class="flex justify-center mx-auto">
            <img class="w-auto h-7 sm:h-8" src="images/logo-icon-no-bg.png" alt="">
        </div>

        <h3 class="mt-3 text-xl font-medium text-center text-gray-600 dark:text-gray-200">{{ __('Reset Password') }}</h3>
        
        @if (session('status'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-medium">Email Sent! </span> {{ session('status') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="w-full mt-4">
                <input id="email" type="email" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-500 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300 @error('email') is-invalid @enderror" name="email" placeholder="Email Address" value="{{ old('email') }}" required autocomplete="email" autofocus aria-label="Email Address" />
                @error('email')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror   
            </div>

            <div class="flex items-center justify-between mt-4">
                <button type="submit" class="px-6 py-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-500 rounded-lg hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </form>
    </div>

    <div class="flex items-center justify-center py-4 text-center bg-gray-50 dark:bg-gray-700">
        <span class="text-sm text-gray-600 dark:text-gray-200">No need for password reset? </span>
        <a href="{{ route('login') }}" class="mx-2 text-sm font-bold text-blue-500 dark:text-blue-400 hover:underline">Login</a>
    </div>
</div>
@endsection