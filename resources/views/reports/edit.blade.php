@extends('layout.layout')

@section('title', __('report.edit'))

@section('content')
<div class="my-20 flex justify-center">
   <div class="flex flex-col w-full max-w-screen-xl md:flex-row">
    <!-- Right Side (Map) -->
    <div class="w-full md:w-1/2 p-4">
         <div class="border rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold text-primary">{{ trans('report.location') }}</h2>
            <div class="mt-4 z-0" id="mapid"></div>
         </div>
      </div>
      <!-- Left Side (Form) -->
      <div class="w-full md:w-1/2 p-4">
         <div class="border rounded-lg shadow-lg">
            @if (request('action') == 'delete' && $report)
            @can('delete', $report)
            <div class="bg-white rounded-lg shadow-md p-4">
               <div class="bg-secondary text-white py-2 px-4 text-center font-semibold">{{ __('report.delete') }}</div>
               <div class="p-4">
                  <label class="text-primary font-semibold">Report Name</label>
                  <p>{{ $report->name }}</p>
                  <label class="text-primary font-semibold">{{ __('report.address') }}</label>
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
            <div class="card p-4">
               <div class="card-header">
                  <h1 class="text-2xl font-bold text-primary">{{ __('report.edit') }}</h1>
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
                     <div class="flex space-x-4 mb-4 hidden">
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
                     <div class="p-2 w-full">
                        <div class="relative">
                           <label for="photo" class="leading-7 text-sm text-gray-600">Photo</label>
                           <input
                              class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                              name="photo[]"
                              type="file"
                              id="photo"
                              multiple>
                           <div class="flex items-center place-content-center px-4 py-4 bg-gray-100 hover:bg-gray-200">
                              @if (!is_null($report->photo))
                              @foreach (json_decode($report->photo) as $image)
                              <a href="{{ asset($image) }}" data-fancybox="gallery" class="mr-4">
                              <img src="{{ asset($image) }}" width="100" height="100" class="rounded-lg border-solid border-2 border-primary" />
                              </a>
                              @endforeach
                              @else
                              {{ __('report.no_photo') }}
                              @endif
                           </div>
                           <div class="px-4 py-4 bg-gray-100 hover:bg-gray-200" id="newImagesContainer" hidden>
                              <div class="block text-sm font-medium text-gray-600">
                                 New Images
                                 <div class="flex items-center place-content-center">
                                    <div id="photoPreviews"></div>
                                 </div>
                              </div>
                           </div>
                           {!! $errors->first('photo', '<span class="text-red-500 text-sm">:message</span>') !!}
                        </div>
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
                  </div>
                  <div class="card-footer">
                     <input type="submit" value="{{ __('report.update') }}" class="px-4 py-2 bg-green-500 text-white rounded-full hover:bg-green-600">
                     <a href="{{ route('reports.show', $report) }}" class="text-indigo-700 hover:underline float-right mx-5">{{ __('app.cancel') }}</a>
                     @can('delete', $report)
                     <a href="{{ route('reports.edit', [$report, 'action' => 'delete']) }}" id="del-report-{{ $report->id }}" class="text-red-700 hover:underline float-right mx-5">{{ __('app.delete') }}</a>
                     @endcan
                  </div>
               </form>
            </div>
            @endif
         </div>
      </div>
   </div>
</div>

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>

<style>
    #mapid { height: 300px; }
</style>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>
    var mapCenter = [{{ $report->latitude }}, {{ $report->longitude }}];
    var map = L.map('mapid').setView(mapCenter, {{ config('leaflet.detail_zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var circle, lat, long, accuracy;
    var featureGroup;
    var customPopup = L.popup({ closeButton: false }); // Create the custom popup

    function getPosition(position) {
        lat = position.coords.latitude;
        long = position.coords.longitude;
        accuracy = position.coords.accuracy;

        if (customPopup) {
            map.removeLayer(customPopup);
        }

        if (circle) {
            map.removeLayer(circle);
        }

        // Set the content of the custom popup
        var customPopupContent = '<div class="custom-popup">Current Location</div>';
        customPopup.setLatLng([lat, long]).setContent(customPopupContent);
        circle = L.circle([lat, long], { radius: 500 });

        // Add the custom popup to the map
        featureGroup = L.featureGroup([customPopup, circle]).addTo(map);

        console.log("Your coordinate is: Lat: " + lat + " Long: " + long + " Accuracy: " + accuracy);

        // Set a custom zoom level when getting user's location
        // map.setView([lat, long], 10); // Adjust the zoom level (15 in this example)
    }

    // Getting user location and max radius (500 meter)
    if (!navigator.geolocation) {
        console.log("Your browser doesn't support geolocation feature!")
    } else {
        setInterval(() => {
            navigator.geolocation.getCurrentPosition(getPosition)
        }, 5000);
    };

    // Create the custom icon
    var customIcon = L.icon({
        iconUrl: '{{ $firstImageUrl }}', // Replace with your custom icon image URL
        iconSize: [35, 35], // Customize icon size if needed
    });

    // Add CSS classes and styles to the custom icon
    customIcon.options.className = 'custom-pin'; // Add your custom CSS class
    customIcon.options.iconSize = [35, 35]; // Modify icon size

    // Add CSS classes and styles to the custom icon
    customIcon.options.className = 'custom-pin'; // Add your custom CSS class
    customIcon.options.iconSize = [35, 35]; // Modify icon size

    var reportMarker = L.marker(mapCenter, { icon: customIcon }).addTo(map);
    function updateMarker(lat, lng, address) {
        reportMarker
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
@endsection
