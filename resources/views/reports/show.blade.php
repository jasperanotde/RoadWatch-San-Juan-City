@extends('layout.layout')

@section('title', __('report.detail'))

@section('content')
<br><br><br><br><br>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Report Details</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>Report Name<td>{{ $report->name }}</td></tr>
                        <tr><td>report Address</td><td>{{ $report->address }}</td></tr>
                        <tr><td>Details</td><td>{{ $report->details }}</td></tr>
                        <tr><td>Photo</td><td><img src="{{ asset($report->photo) }}" width= '50' height='50' class="img img-responsive" /></td>
                        <tr><td>Severity</td><td>{{ $report->severity }}</td></tr>
                        <tr><td>Urgency</td><td>{{ $report->urgency }}</td></tr>

                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $report)
                    <a href="{{ route('reports.edit', $report) }}" id="edit-report-{{ $report->id }}" class="btn btn-warning">Edit Report</a>
                @endcan
                @if(auth()->check())
                    <a href="{{ route('reports.index') }}" class="btn btn-link">Back to Reports</a>
                @else
                    <a href="{{ route('report_map.index') }}" class="btn btn-link">{{ __('report.back_to_index') }}</a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ trans('report.location') }}</div>
            @if ($report->coordinate)
            <div class="card-body" id="mapid"></div>
            @else
            <div class="card-body">{{ __('report.no_coordinate') }}</div>
            @endif
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
