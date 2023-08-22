@extends('layout.layout')

@section('title', __('report.edit'))

@section('content')
<br><br><br><br><br>

<div class="flex justify-center">
    <div class="flex w-full max-w-screen-xl">
        <!-- Left Side (Form) -->
        <div class="w-1/2 p-4">
            <div class="border rounded-lg shadow-lg">
                @if (request('action') == 'delete' && $report)
                    @can('delete', $report)
                    <div class="bg-white rounded-lg shadow-md p-4">
    <div class="bg-blue-500 text-white py-2 px-4 text-center font-semibold">{{ __('report.delete') }}</div>
    <div class="p-4">
        <label class="text-blue-600 font-semibold">Report Name</label>
        <p>{{ $report->name }}</p>
        <label class="text-blue-600 font-semibold">{{ __('report.address') }}</label>
        <p>{{ $report->address }}</p>
        {!! $errors->first('report_id', '<span class="text-red-500" role="alert">:message</span>') !!}
    </div>
    <hr class="my-0 border-gray-300">
    <div class="p-4 text-red-500">{{ __('report.delete_confirm') }}</div>
    <div class="flex justify-end p-4">
        <form
            enctype="multipart/form-data"
            method="POST"
            action="{{ route('reports.destroy', $report) }}"
            accept-charset="UTF-8"
            onsubmit="return confirm('{{ __('app.delete_confirm') }}')"
            class="flex space-x-4"
        >
            @csrf
            @method('delete')
            <input name="report_id" type="hidden" value="{{ $report->id }}">
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg">{{ __('app.delete_confirm_button') }}</button>
        </form>
        <a href="{{ route('reports.edit', $report) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg ml-2">{{ __('app.cancel') }}</a>
    </div>
</div>

                    @endcan
                @else
                    <div class="card">
                        <div class="card-header">
                            <h1 class="text-2xl font-bold text-indigo-700">{{ __('report.edit') }}</h1>
                        </div>
                        <form
                            method="POST"
                            enctype="multipart/form-data"
                            action="{{ route('reports.update', $report) }}"
                            accept-charset="UTF-8"
                        >
                            @csrf
                            @method('patch')
                            <div class="card-body">
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-600">{{ __('report.name') }}</label>
                                    <input
                                        id="name"
                                        type="text"
                                        class="mt-1 p-2 w-full rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}"
                                        name="name"
                                        value="{{ old('name', $report->name) }}"
                                        required
                                    >
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="address" class="block text-sm font-medium text-gray-600">{{ __('report.address') }}</label>
                                    <textarea
                                        id="address"
                                        class="mt-1 p-2 w-full rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $errors->has('address') ? 'border-red-500' : 'border-gray-300' }}"
                                        name="address"
                                        rows="4"
                                    >{{ old('address', $report->address) }}</textarea>
                                    @error('address')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex space-x-4 mb-4">
                                    <div class="w-1/2">
                                        <label for="latitude" class="block text-sm font-medium text-gray-600">{{ __('report.latitude') }}</label>
                                        <input
                                            id="latitude"
                                            type="text"
                                            class="mt-1 p-2 w-full rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $errors->has('latitude') ? 'border-red-500' : 'border-gray-300' }}"
                                            name="latitude"
                                            value="{{ old('latitude', $report->latitude) }}"
                                            required
                                        >
                                        @error('latitude')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="w-1/2">
                                        <label for="longitude" class="block text-sm font-medium text-gray-600">{{ __('report.longitude') }}</label>
                                        <input
                                            id="longitude"
                                            type="text"
                                            class="mt-1 p-2 w-full rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $errors->has('longitude') ? 'border-red-500' : 'border-gray-300' }}"
                                            name="longitude"
                                            value="{{ old('longitude', $report->longitude) }}"
                                            required
                                        >
                                        @error('longitude')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="details" class="block text-sm font-medium text-gray-600">{{ __('report.details') }}</label>
                                    <textarea
                                        id="details"
                                        class="mt-1 p-2 w-full rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $errors->has('details') ? 'border-red-500' : 'border-gray-300' }}"
                                        name="details"
                                        rows="4"
                                    >{{ old('details', $report->details) }}</textarea>
                                    @error('details')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="urgency" class="block text-sm font-medium text-gray-600">{{ __('report.urgency') }}</label>
                                    <select
                                        id="urgency"
                                        name="urgency"
                                        class="mt-1 p-2 w-full rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $errors->has('urgency') ? 'border-red-500' : 'border-gray-300' }}"
                                    >
                                        <option value="Urgent" {{ old('urgency', $report->urgency) === 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                        <option value="Non-Urgent" {{ old('urgency', $report->urgency) === 'Non-Urgent' ? 'selected' : '' }}>Non-Urgent</option>
                                        <option value="3" {{ old('urgency', $report->urgency) === '3' ? 'selected' : '' }}>Three</option>
                                    </select>
                                    @error('urgency')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="photo" class="block text-sm font-medium text-gray-600">{{ __('report.photo') }}</label>
                                    <input
                                        id="photo"
                                        type="file"
                                        class="mt-1 p-2 w-full rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $errors->has('photo') ? 'border-red-500' : 'border-gray-300' }}"
                                        name="photo"
                                    >
                                    @error('photo')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                    @if ($report->photo)
                                        <div class="mt-2">
                                            <img src="{{ asset($report->photo) }}" alt="Current Photo" class="max-w-xs">
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label for="severity" class="block text-sm font-medium text-gray-600">{{ __('report.severity') }}</label>
                                    <select
                                        id="severity"
                                        name="severity"
                                        class="mt-1 p-2 w-full rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $errors->has('severity') ? 'border-red-500' : 'border-gray-300' }}"
                                    >
                                        <option value="Mild" {{ old('severity', $report->severity) === 'Mild' ? 'selected' : '' }}>Mild</option>
                                        <option value="Moderate" {{ old('severity', $report->severity) === 'Moderate' ? 'selected' : '' }}>Moderate</option>
                                        <option value="Severe Damage" {{ old('severity', $report->severity) === 'Severe Damage' ? 'selected' : '' }}>Severe Damage</option>
                                    </select>
                                    @error('severity')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div id="mapid" class="h-80"></div>
                            </div>

                            <div class="card-footer">
                                <input type="submit" value="{{ __('report.update') }}" class="px-4 py-2 bg-green-500 text-white rounded-full hover:bg-green-600">
                                <a href="{{ route('reports.show', $report) }}" class="text-indigo-700 hover:underline ">{{ __('app.cancel') }}</a>

                                @can('delete', $report)
                                    <a href="{{ route('reports.edit', [$report, 'action' => 'delete']) }}" id="del-report-{{ $report->id }}" class="text-red-700 hover:underline float-right">{{ __('app.delete') }}</a>
                                @endcan
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Side (Map) -->
        <div class="w-1/2 p-4">
            <div class="border rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-indigo-700">{{ trans('report.location') }}</h2>
                <div class="mt-4" id="mapid"></div>
            </div>
        </div>
    </div>
</div>


@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>

<style>
    #mapid { height: 300px; }
</style>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>
<script>
    var mapCenter = [{{ $report->latitude }}, {{ $report->longitude }}];
    var map = L.map('mapid').setView(mapCenter, {{ config('leaflet.detail_zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker(mapCenter).addTo(map);
    function updateMarker(lat, lng) {
        marker
        .setLatLng([lat, lng])
        .bindPopup("Your location :  " + marker.getLatLng().toString())
        .openPopup();
        return false;
    };

    map.on('click', function(e) {
        let latitude = e.latlng.lat.toString().substring(0, 15);
        let longitude = e.latlng.lng.toString().substring(0, 15);
        $('#latitude').val(latitude);
        $('#longitude').val(longitude);
        updateMarker(latitude, longitude);
    });

    var updateMarkerByInputs = function() {
        return updateMarker( $('#latitude').val() , $('#longitude').val());
    }
    $('#latitude').on('input', updateMarkerByInputs);
    $('#longitude').on('input', updateMarkerByInputs);
    
</script>
@endpush
@endsection
