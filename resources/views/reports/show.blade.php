@extends('layout.layout')

@section('title', __('report.detail'))

@section('content')
<br><br><br><br><br>
<div class="flex justify-center">
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
                        <a href="{{ route('reports.edit', $report) }}" id="edit-report-{{ $report->id }}" class="px-4 py-2 bg-primary text-white rounded-full mr-2">Edit Report</a>
                    @endcan
                    @if(auth()->check())
                        <a href="{{ route('reports.index') }}" class="text-indigo-700 hover:underline">Back to Reports</a>
                    @else
                        <a href="{{ route('report_map.index') }}" class="text-indigo-700 hover:underline">{{ __('report.back_to_index') }}</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Side (Map) -->
        <div class="w-1/2 p-4">
            <div class="border rounded-lg shadow-lg p-6">
                <h1 class="text-xl font-bold text-indigo-700">{{ trans('report.location') }}</h1>
                @if ($report->coordinate)
                    <div id="mapid" class="h-80"></div>
                @else
                    <p>{{ __('report.no_coordinate') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>

<!-- map syle (please move it to the css public folder) -->
<style>
    #mapid { height: 400px; }
</style>

@endsection
@push('scripts')

<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>

<script>
    var map = L.map('mapid').setView([{{ $report->latitude }}, {{ $report->longitude }}], {{ config('leaflet.detail_zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([{{ $report->latitude }}, {{ $report->longitude }}]).addTo(map)
        .bindPopup('{!! $report->map_popup_content !!}');
</script>
@endpush
