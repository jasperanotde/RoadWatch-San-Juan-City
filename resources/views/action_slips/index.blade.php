@extends('layout.layout')

@section('content')
<br><br><br><br><br>
<div class="container mx-auto">
    <h1 class="text-2xl font-semibold mb-4">Action Slips</h1>

    <a href="{{ route('action_slips.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
        Create Action Slip
    </a>

    <br><br>

    @if(session('success'))
    <div class="bg-green-200 text-green-800 border border-green-400 rounded p-2 mb-4">
        {{ session('success') }}
    </div>
    @endif

    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="text-left py-2 px-4">Title</th>
                <th class="text-left py-2 px-4">Description</th>
                <th class="text-left py-2 px-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($actionSlips as $actionSlip)
            <tr>
                <td class="py-2 px-4">{{ $actionSlip->title }}</td>
                <td class="py-2 px-4">{{ $actionSlip->description }}</td>
                <td class="py-2 px-4">
                    <a href="{{ route('action_slips.show', $actionSlip->id) }}" class="text-blue-500 hover:underline">View</a>
                    <a href="{{ route('action_slips.edit', $actionSlip->id) }}" class="text-yellow-500 hover:underline ml-2">Edit</a>
                    <form action="{{ route('action_slips.destroy', $actionSlip->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('Are you sure you want to delete this action slip?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center py-4">No action slips found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<br><br><br>
@endsection
