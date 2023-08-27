@extends('layout.layout')

@section('title', __('report.create'))

@section('content')

<div class="my-20 flex justify-center">
  <div class="flex w-full max-w-screen-xl">
    <!-- Left Side (Form) -->
    <div class="w-1/2 p-4">
      <div class="border rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-indigo-700 mb-4">Report a Road Damage</h1>
        <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data" accept-charset="UTF-8">
          {{ csrf_field() }}
          <div class="p-2 w-full">
        <div class="relative">
          <label for="name" class="leading-7 text-sm text-gray-600">Report Name</label>
          <input
            type="text"
            id="name"
            name="name"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
            value="{{ old('name') }}"
            required
          >
          {!! $errors->first('name', '<span class="text-red-500 text-sm">:message</span>') !!}
        </div>
      </div>
      <div class="p-2 w-full">
        <div class="relative">
          <label for="address" class="leading-7 text-sm text-gray-600">Report Address</label>
          <textarea
            id="address"
            name="address"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
            rows="4"
          >{{ old('address', request('address')) }}</textarea>
          {!! $errors->first('address', '<span class="text-red-500 text-sm">:message</span>') !!}
        </div>
      </div>

      <div class="flex ml-2 hidden">
            <div class="flex-1 pr-2">
              <div class="form-group">
                <label for="latitude" class="control-label">{{ __('report.latitude') }}</label>
                <input id="latitude" type="text" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }} bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700" name="latitude" value="{{ old('latitude', request('latitude')) }}" required>
                {!! $errors->first('latitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
              </div>
            </div>

            <div class="flex-1 pl-2">
              <div class="form-group">
                <label for="longitude" class="control-label">{{ __('report.longitude') }}</label>
                <input id="longitude" type="text" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }} bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 " name="longitude" value="{{ old('longitude', request('longitude')) }}" required>
                {!! $errors->first('longitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
              </div>
            </div>
          </div>

      <div class="p-2 w-full">
        <div class="relative">
          <label for="details" class="leading-7 text-sm text-gray-600">Details</label>
          <textarea
            id="details"
            name="details"
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
            rows="4"
          >{{ old('details') }}</textarea>
          {!! $errors->first('details', '<span class="text-red-500 text-sm">:message</span>') !!}
        </div>
      </div>
      <div class="p-2 w-full">
        <div class="relative">
          <label for="urgency" class="leading-7 text-sm text-gray-600">Urgency</label>
          <select
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
            name="urgency"
            required
          >
            <option selected disabled>Select Urgency</option>
            <option value="Urgent">Urgent</option>
            <option value="Non-Urgent">Non-Urgent</option>
          </select>
          {!! $errors->first('urgency', '<span class="text-red-500 text-sm">:message</span>') !!}
        </div>
      </div>
      <div class="p-2 w-full">
        <div class="relative">
          <label for="photo" class="leading-7 text-sm text-gray-600">Photo</label>
          <input
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
            name="photo"
            type="file"
            id="photo"
          >
          {!! $errors->first('photo', '<span class="text-red-500 text-sm">:message</span>') !!}
        </div>
      </div>
      <div class="p-2 w-full">
        <div class="relative">
          <label for="severity" class="leading-7 text-sm text-gray-600">Severity</label>
          <select
            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
            name="severity"
            required>
            <option selected disabled>Select Severity</option>
            <option value="Mild">Mild</option>
            <option value="Moderate">Moderate</option>
            <option value="Severe Damage">Severe Damage</option>
          </select>
          {!! $errors->first('severity', '<span class="text-red-500 text-sm">:message</span>') !!}
        </div>
      </div>
          
          <!-- Submit and Cancel Buttons -->
          <div class="mt-6 flex justify-between items-center">
            <input type="submit" value="{{ __('report.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-full hover:bg-green-600">
            <a href="{{ route('reports.index') }}" class="text-indigo-700 hover:underline">{{ __('app.cancel') }}</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Right Side (Map) -->
    <div class="w-1/2 p-4">
      <div class="border rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold text-indigo-700">{{ trans('report.location') }}</h2>
        <div class="mt-4 z-0" id="mapid"></div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
      
<style>
    #mapid { height: 300px; }
</style>
@endsection

@push('scripts')
<!-- Make sure you put this AFTER Leaflet's CSS -->

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
       
<script>
    var mapCenter = [{{ request('latitude', config('leaflet.map_center_latitude')) }}, {{ request('longitude', config('leaflet.map_center_longitude')) }}];
    var map = L.map('mapid').setView(mapCenter, {{ config('leaflet.zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker(mapCenter).addTo(map);

    function updateMarker(lat, lng, address) {
        marker
        .setLatLng([lat, lng])
        .bindPopup("Your location :  " + address)
        .openPopup();
        return false;
    };

    var geocoder = L.Control.Geocoder.nominatim();

    map.on('click', function(e) {
      let latitude = e.latlng.lat.toString().substring(0, 15);
      let longitude = e.latlng.lng.toString().substring(0, 15);

        geocoder.reverse(e.latlng, map.options.crs.scale(map.getZoom()), function(results) {
        let address = results[0] ? results[0].name : "Address not found";
          $('#address').val(address);
          $('#latitude').val(latitude);
          $('#longitude').val(longitude);
          updateMarker(latitude, longitude, address);
      });
    });

    var updateMarkerByInputs = function() {
        return updateMarker( $('#latitude').val() , $('#longitude').val() , $('#address').val(address) );
    }
    $('#latitude').on('input', updateMarkerByInputs);
    $('#longitude').on('input', updateMarkerByInputs);
    $('#address').on('input', updateMarkerByInputs);
</script>
@endpush
