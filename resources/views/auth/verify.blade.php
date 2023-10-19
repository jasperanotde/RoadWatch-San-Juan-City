@extends('layout.layout')

@section('content')
<div class="w-full max-w-sm mx-auto my-28 overflow-hidden bg-white rounded-lg shadow-md">
    <div class="flex justify-center my-10">
        <div class="w-8/12">
            <div class="bg-white shadow-md rounded-lg">
                <div class="bg-primary text-white font-bold py-2 px-4">
                    {{ __('Verify Your Email Address') }}
                </div>

                <div class="p-4">
                    @if (session('resent'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ __('A fresh verification link has been sent to your email address.') }}</span>
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="text-blue-500 hover:underline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
