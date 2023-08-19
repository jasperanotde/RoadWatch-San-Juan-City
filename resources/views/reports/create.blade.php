@extends('layout.layout')

@section('title', __('report.create'))

@section('content')
<br><br><br><br><br>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div style="border:none" class="card">
            <div class="card-header"><h1 style="color: #113F67; font-size: 40px; font-weight: 900;">Report a Road Damage</h1></div>
            <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data" accept-charset="UTF-8">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Report Name</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Report Address</label>
                        <textarea id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" rows="4">{{ old('address') }}</textarea>
                        {!! $errors->first('address', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude" class="control-label">{{ __('report.latitude') }}</label>
                                <input id="latitude" type="text" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" name="latitude" value="{{ old('latitude', request('latitude')) }}" required>
                                {!! $errors->first('latitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude" class="control-label">{{ __('report.longitude') }}</label>
                                <input id="longitude" type="text" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" name="longitude" value="{{ old('longitude', request('longitude')) }}" required>
                                {!! $errors->first('longitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="details" class="control-label">Details</label>
                        <textarea id="details" class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}" name="details" rows="4">{{ old('details') }}</textarea>
                        {!! $errors->first('details', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>

                    <div class="form-group">
<label for="details" class="control-label">Urgency</label>
                    <select class="form-select form-control{{ $errors->has('urgency') ? ' is-invalid' : '' }}" name="urgency" value="{{ old('urgency') }}" required aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="Urgent">Urgent</option>
                            <option value="Non-Urgent">Non-Urgent</option>
                            <option value="3">Three</option>
                        </select>
                        {!! $errors->first('urgency', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
</div>

           <div style="padding: 0 1.5em;" class="form-group">
           <label for="photo" class="control-label">Photo</label>
             <input  class="form-control" name="photo" type="file" id="photo">
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

                    <input style="margin: 1.5em;background:green;" type="submit" value="{{ __('report.create') }}" style="background: #113F67;" class="btn btn-success">
                    <a href="{{ route('reports.index') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </form>
        </div>

            <div class="card-header">{{ trans('report.location') }}</div>

            <div class="card-body" id="mapid"></div>
         
        </div>
    </div>
    </div>




</div>

@endsection

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
    var mapCenter = [{{ request('latitude', config('leaflet.map_center_latitude')) }}, {{ request('longitude', config('leaflet.map_center_longitude')) }}];
    var map = L.map('mapid').setView(mapCenter, {{ config('leaflet.zoom_level') }});

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
