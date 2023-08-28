@extends('layout.layout')

@section('title', __('report.detail'))

@section('content')
<div class="flex justify-center m-20">
    <div class="flex w-full max-w-screen-xl">
        <!-- Left Side (Report Details) -->
        <div class="w-1/2 p-4">
            <div class="border rounded-lg shadow-lg p-6">
                <h1 class="text-xl font-bold text-primary mb-3 underline">Report Details</h1>
                <table class="table-auto">
                    <tbody>
                        <tr>
                            <td class="pr-4">Report Name</td>
                            <td>{{ $report->name }}</td>
                        </tr>
                        <tr>
                            <td class="pr-4">Report Address</td>
                            <td>{{ $report->address }}</td>
                        </tr>
                        <tr>
                            <td class="pr-4">Details</td>
                            <td>{{ $report->details }}</td>
                        </tr>
                        <tr>
                            <td class="pr-4">Photo</td>
                            <td>
                                @if($report->photo)
                                    <img src="{{ asset($report->photo) }}" width="50" height="50" class="img img-responsive" />
                                @else
                                    {{ __('report.no_photo') }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="pr-4">Severity</td>
                            <td>{{ $report->severity }}</td>
                        </tr>
                        <tr>
                            <td class="pr-4">Urgency</td>
                            <td>{{ $report->urgency }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-4">
                    @can('update', $report)
                        <a href="{{ route('reports.edit', ['report' => $report, 'image' => $report->getPhoto()]) }}" id="edit-report-{{ $report->id }}" class="px-4 py-2 bg-primary text-white rounded-full mr-2">Edit Report</a>
                    @endcan
                    @if(auth()->check())
                        <a href="{{ route('reports.index') }}" class="text-indigo-700 hover:underline float-right">Back to Reports</a>
                    @else
                        <a href="{{ route('report_map.index') }}" class="text-indigo-700 hover:underline">{{ __('report.back_to_index') }}</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Side (Map) -->
        <div class="w-1/2 p-4">
            <div class="border rounded-lg shadow-lg p-6">
                <h1 class="text-xl font-bold text-primary">{{ trans('report.location') }}</h1>
                @if ($report->coordinate)
                    <div id="mapid" class="h-80 z-0"></div>
                @else
                    <p>{{ __('report.no_coordinate') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>

<!-- map syle (please move it to the css public folder) -->
<style>
    #mapid { height: 400px; }
</style>

@endsection
@push('scripts')

<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
        <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    
    var map = L.map('mapid').setView([{{ $report->latitude }}, {{ $report->longitude }}], {{ config('leaflet.detail_zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // This is for the pin of the report
    // Get the image URL from the URL parameters
    var imageUrl = '{{ request()->query('image') }}';

    // Create the custom icon
    var customIcon = L.icon({
        iconUrl: imageUrl, // Replace with your custom icon image URL
        iconSize: [35, 35], // Customize icon size if needed
    });

    // Add CSS classes and styles to the custom icon
    customIcon.options.className = 'custom-pin'; // Add your custom CSS class
    customIcon.options.iconSize = [35, 35]; // Modify icon size

    // Create the marker using the custom icon and add it to the map
    var reportMarker = L.marker([{{ $report->latitude }}, {{ $report->longitude }}], { icon: customIcon })
        .addTo(map)
        .bindPopup('{!! $report->map_popup_content !!}');
</script>
@endpush
