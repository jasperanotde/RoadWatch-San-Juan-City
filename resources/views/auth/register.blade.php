@extends('layout.layout')

@section('content')

<div class="w-full max-w-sm mx-auto my-28 overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
    <div class="px-6 py-4">
        <div class="flex justify-center mx-auto">
            <img class="w-auto h-7 sm:h-8" src="images/logo-icon-no-bg.png" alt="">
        </div>

        <h3 class="mt-3 text-xl font-medium text-center text-gray-600 dark:text-gray-200">{{ __('Register') }}</h3>

        <p class="mt-1 text-center text-gray-500 dark:text-gray-400">{{ __('Create new account') }}</p>

        <form id="phoneForm" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="w-full mt-4">
                <input id="name" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-500 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300 @error('email') is-invalid @enderror" name="name" placeholder="Name" value="{{ old('name') }}" required autocomplete="name" autofocus aria-label="Name" />
                @error('name')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror   
            </div>

            <div class="w-full mt-4">
                <input id="email" type="email" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-500 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300 @error('email') is-invalid @enderror" name="email" placeholder="Email Address" value="{{ old('email') }}" required autocomplete="email" autofocus aria-label="Email Address" />
                @error('email')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror   
            </div>

            <div class="w-full mt-4">
                <input id="contact_number"class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-500 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300 @error('contact_number') is-invalid @enderror" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" placeholder="Contact Number (ex: 639456331110)" required autocomplete="contact_number">
                @error('contact_number')
                    <p class="text-red-500 mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </p>
                @enderror
            </div>

            <div class="w-full mt-4">
                <div class="relative">
                    <input id="password" type="password" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-500 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300 @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password" aria-label="Password"/>
                    @error('password')  
                        <p class="text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <div id="set" class="absolute right-2.5 bottom-2.5">
                        <i id="see" class="far fa-eye"></i>
                    </div>
                </div>
                <div class="text-primary ml-4 mt-2">
                    <div id="check0">
                            <i class="far fa-check-circle"></i>  <span> Length more than 5.</span>
                    </div>
                    <div id="check1">
                            <i class="far fa-check-circle"></i>  <span> Length less than 10.</span>
                    </div>
                    <div id="check2">
                            <i class="far fa-check-circle"></i>  <span> Contains numerical character.</span>
                    </div>
                    <div id="check3">
                            <i class="far fa-check-circle"></i>   <span>Contains special character.</span>
                    </div>
                    <div id="check4">
                            <i class="far fa-check-circle"></i>  <span>Shouldn't contain spaces.</span>
                    </div>
                </div>
            </div>

            <div class="w-full mt-4">
                <input id="password-confirm" type="password" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-500 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
         </div>

            <div class="flex items-center justify-between mt-4">
                <button type="submit" class="px-6 py-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-500 rounded-lg hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>

    <div class="flex items-center justify-center py-4 text-center bg-gray-50 dark:bg-gray-700">
           <span class="text-sm text-gray-600 dark:text-gray-200">Already have an account? </span>
        <a href="{{ route('login') }}" class="mx-2 text-sm font-bold text-blue-500 dark:text-blue-400 hover:underline">Login</a>
    </div>
</div>
@endsection