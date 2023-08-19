@extends('layout.layout')

@section('title', __('report.edit'))

@section('content')
<br><br><br><br><br>
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $report)
        @can('delete', $report)
            <div class="card">
                <div class="card-header">{{ __('report.delete') }}</div>
                <div class="card-body">
                    <label class="control-label text-primary">Report Name </label>
                    <p>{{ $report->name }}</p>
                    <label class="control-label text-primary">{{ __('report.address') }}</label>
                    <p>{{ $report->address }}</p>
                    <label class="control-label text-primary">{{ __('report.latitude') }}</label>
                    <p>{{ $report->latitude }}</p>
                    <label class="control-label text-primary">{{ __('report.longitude') }}</label>
                    <p>{{ $report->longitude }}</p>
                    <label class="control-label text-primary">{{ __('report.region') }}</label>
                    <p>{{ $report->region }}</p>
                    {!! $errors->first('report_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">{{ __('report.delete_confirm') }}</div>
                <div class="card-footer">
                    <form enctype="multipart/form-data" method="POST" action="{{ route('reports.destroy', $report) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                        {{ csrf_field() }} {{ method_field('delete') }}
                        <input name="report_id" type="hidden" value="{{ $report->id }}">
                        <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                    </form>
                    <a href="{{ route('reports.edit', $report) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header"><h1 style="color: #113F67; font-size: 40px; font-weight: 900;">Edit Report</h1></div>
            <form method="POST" enctype="multipart/form-data" action="{{ route('reports.update', $report) }}" accept-charset="UTF-8">
                {{ csrf_field() }} {{ method_field('patch') }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Report Name</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $report->name) }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">{{ __('report.address') }}</label>
                        <textarea id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" rows="4">{{ old('address', $report->address) }}</textarea>
                        {!! $errors->first('address', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude" class="control-label">{{ __('report.latitude') }}</label>
                                <input id="latitude" type="text" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" name="latitude" value="{{ old('latitude', $report->latitude) }}" required>
                                {!! $errors->first('latitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude" class="control-label">{{ __('report.longitude') }}</label>
                                <input id="longitude" type="text" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" name="longitude" value="{{ old('longitude', $report->longitude) }}" required>
                                {!! $errors->first('longitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="details" class="control-label">Details</label>
                        <textarea id="details" class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}" name="details" rows="4">{{ old('details', $report->details) }}</textarea>
                        {!! $errors->first('details', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    
                    <label for="urgency" class="control-label">Urgency</label>
                    <select class="form-select form-control{{ $errors->has('urgency') ? ' is-invalid' : '' }}" name="urgency" value="{{ old('urgency') }}" required aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="Urgent">Urgent</option>
                            <option value="Non-Urgent">Non-Urgent</option>
                            <option value="3">Three</option>
                        </select>
                        {!! $errors->first('urgency', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    
                    <div style="margin-left: 20px;" class="form-group">
                        <input class="form-control" name="photo" type="file" id="photo">
                        {!! $errors->first('photo', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>

                    <div style="padding: 0 1.5em;" class="form-group">
                    <label for="severity" class="control-label">Severity</label>
                    <select class="form-select form-control{{ $errors->has('severity') ? ' is-invalid' : '' }}" name="severity" value="{{ old('severity') }}" required aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="Mild">Mild</option>
                            <option value="Moderate">Moderate</option>
                            <option value="Severe Damage">Severe Damage</option>
                        </select>
                        {!! $errors->first('severity', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                    
                    <div id="mapid"></div>
                    <div class="card-footer">
                    <input type="submit" value="{{ __('report.update') }}" style="background: lightgreen"class="btn btn-success">
                    <a href="{{ route('reports.show', $report) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @can('delete', $report)
                        <a href="{{ route('reports.edit', [$report, 'action' => 'delete']) }}" id="del-report-{{ $report->id }}" class="btn btn-danger float-right">{{ __('app.delete') }}</a>
                    @endcan
                </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endif

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
