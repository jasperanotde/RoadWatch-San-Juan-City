@extends('layout.layout')

@section('content')
<div class="w-full max-w-sm mx-auto my-28 overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
    <div class="px-6 py-4">
        <div class="flex justify-center mx-auto">
            <img class="w-auto h-7 sm:h-8" src="images/logo-icon-no-bg.png" alt="">
        </div>

        <h3 class="mt-3 text-xl font-medium text-center text-gray-600 dark:text-gray-200">{{ __('Welcome to San Juan City Road Damages Reporting System') }}</h3>

        <p class="mt-1 text-center text-gray-500 dark:text-gray-400">{{ __('Login or Create an account') }}</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="w-full mt-4">
                <input id="email" type="email" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-500 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300 @error('email') is-invalid @enderror" name="email" placeholder="Email Address" value="{{ old('email') }}" required autocomplete="email" autofocus aria-label="Email Address" />
                @error('email')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror   
            </div>

            <div class="w-full mt-4">
                <input id="password" type="password" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-500 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300 @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password" aria-label="Password" />
                @error('password')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <div class="md:col-span-6 md:offset-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-gray-600 dark:text-gray-200 hover:text-gray-500">Forget Password?</a>
                @endif

                <button type="submit" class="px-6 py-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-500 rounded-lg hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                    {{ __('Login') }}
                </button>
            </div>
        </form>
    </div>

    <div class="flex items-center justify-center py-4 text-center bg-gray-50 dark:bg-gray-700">
        <span class="text-sm text-gray-600 dark:text-gray-200">Don't have an account? </span>
        <a href="{{ route('register') }}" class="mx-2 text-sm font-bold text-blue-500 dark:text-blue-400 hover:underline">Register</a>
    </div>
</div>
@endsection
