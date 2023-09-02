@extends('layout.layout')

@section('content')
<br><br><br><br><br>
<div class="container mx-auto">
    <h1 class="text-2xl font-semibold mb-4">Action Slip Details</h1>

    <div class="bg-white rounded shadow p-4 mb-4">
        <h2 class="text-xl font-semibold">{{ $actionSlip->title }}</h2>
        <p class="text-gray-700 mt-2">{{ $actionSlip->description }}</p>
    </div>

    <a href="{{ route('action_slips.index') }}" class="text-blue-500 hover:underline">Back to Action Slips</a>
</div>
<br><br><br>
@endsection
