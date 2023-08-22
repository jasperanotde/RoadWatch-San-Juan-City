@extends('layout.layout')

@section('title', __('report.list'))

@section('content')
<div class="mx-20">


    @section('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
        <style>
            #mapid { 
                min-height: 300px;
                }
        </style>
    @endsection

    @push('scripts')
        <!-- Make sure you put this AFTER Leaflet's CSS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
        <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>
        <script>
            var map = L.map('mapid').setView([{{ config('leaflet.map_center_latitude') }}, {{ config('leaflet.map_center_longitude') }}], {{ config('leaflet.zoom_level') }});

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            
                L.Control.geocoder().addTo(map);
                if (!navigator.geolocation) {
                    console.log("Your browser doesn't support geolocation feature!")
                } else {
                    setInterval(() => {
                        navigator.geolocation.getCurrentPosition(getPosition)
                    }, 5000);
                };

                //getting user location and max radius (1km)
                var marker, circle, lat, long, accuracy;

                function getPosition(position) {
                    // console.log(position)
                    lat = position.coords.latitude
                    long = position.coords.longitude
                    accuracy = position.coords.accuracy

                    if (marker) {
                        map.removeLayer(marker)
                    }

                    if (circle) {
                        map.removeLayer(circle)
                    }

                    marker = L.marker([lat, long])
                    circle = L.circle([lat, long], { radius: 1000 })

                    var featureGroup = L.featureGroup([marker, circle]).addTo(map)
                    console.log("Your coordinate is: Lat: " + lat + " Long: " + long + " Accuracy: " + accuracy)
            
                    //get back to user location
                    document.getElementById('myButton').addEventListener('click', function() {
                        map.fitBounds(featureGroup.getBounds())
                });

                    var button = document.getElementById('myButton');
                    var mapContainer = map.getContainer();
                    mapContainer.appendChild(button);
                }
        
            var markers = L.markerClusterGroup();

            axios.get('{{ route('api.reports.index') }}')
            .then(function (response) {
                var marker = L.geoJSON(response.data, {
                    pointToLayer: function(geoJsonPoint, latlng) {
                        return L.marker(latlng).bindPopup(function (layer) {
                            return layer.feature.properties.map_popup_content;
                        });
                    }
                });
                markers.addLayer(marker);
            })
            .catch(function (error) {
                console.log(error);
            });
            map.addLayer(markers);

            //sattelite layer
            
            var satelliteLayer = L.tileLayer('http://mt0.google.com/vt/lyrs=s&hl=en&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });
            var baseMaps = {
                "Street": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'),
                "Satellite": satelliteLayer
            };
            L.control.layers(baseMaps).addTo(map);

            @can('create', new App\Models\Report)
            var theMarker;
            var geocoder = L.Control.Geocoder.nominatim();

            map.on('click', function(e) {
                let latitude = e.latlng.lat.toString().substring(0, 15);
                let longitude = e.latlng.lng.toString().substring(0, 15);

                if (theMarker != undefined) {
                    map.removeLayer(theMarker);
                };

                geocoder.reverse(e.latlng, map.options.crs.scale(map.getZoom()), function(results) {
                var address = results[0] ? results[0].name : "Address not found";
                var popupContent = "Your location: " + address;
                popupContent += '<br><a href="{{ route('reports.create') }}?latitude=' + latitude + '&longitude=' + longitude + '">Add new report here</a>';

                theMarker = L.marker(e.latlng).addTo(map);
                theMarker.bindPopup(popupContent).openPopup();
                });
                
                theMarker = L.marker([latitude, longitude]).addTo(map);
                theMarker.bindPopup(popupContent)
                .openPopup();
            });
            @endcan
        </script>
    @endpush
 <br><br><br><br>
    <div class="flex justify-between items-center">
        <h1 class="font-josefinsans font-bold flex-grow text-4xl font-normal leading-none tracking-tight font-poppins text-primary"><span class="font-josefinsans font-bold underline underline-offset-3 decoration-7 decoration-secondary">{{ __('app.total') }}:<small> {{ $reports->total() }} Reports </small></h1>
        @can('create', new App\Models\Report)
            <a href="{{ route('reports.create') }}">
                <button class="mt-1 mx-2 md:mt-4 md:mx-3 px-4 py-1.5 md:px-9 md:py-2.5 bg-primary text-white text-xxs md:text-xs font-poppins font-normal rounded hover:bg-secondary focus:outline-none focus:bg-primary transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300">Create New Report</button>
            </a>
        @endcan
    </div>

    <br>
<!-- Try mo ito zyre, for search ito and pag detch ng mga data pero di ko pa napapagana. If mapapagana mu -->
<!--
    <div class="mb-3 mt-5 mx-40">
        <div class="relative mb-5 flex w-full flex-wrap items-stretch">
            <input
            id="datatable-search-input"
            type="search"
            class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
            placeholder="Search"
            aria-label="Search"
            aria-describedby="button-addon1" />
        </div>
    </div>
    <div id="datatable"></div>

    <script>
        import {
    Datatable,
    initTE,
  } from "tw-elements";

  initTE({ Datatable });

  const data = {
    columns: [
      { label: 'Name', field: 'name' },
      { label: 'location', field: 'address' },
      { label: 'Severity', field: 'severity' },
      { label: 'Urgency', field: 'urgency' },
      { label: 'Photo', field: 'photo' },
      { label: 'Status', field: 'status' },
    ],
    rows: [
        @foreach($reports as $report)
        [
            "{{ $report->name }}",
            "{{ $report->address }}",
            "{{ $report->severity }}"
            "{{ $report->urgency }}",
            "{{ $report->photo }}",
            "{{ $report->status }}",
        ],
        @endforeach
    ],
  };
  
  const instance = new Datatable(document.getElementById('datatable'), data)
  
  document.getElementById('datatable-search-input').addEventListener('input', (e) => {
    instance.search(e.target.value);
  });
    </script>
-->

<div class="max-w-2xl mx-auto">

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="p-4">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative mt-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <input type="text" id="table-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
            <div class="absolute top-0 right-0  ml-4">
                <a href="{{ route('reports.create') }}">
            <button class="bg-primary text-white p-2 rounded hover:bg-secondary m-2 font-bold py-2 px-4 rounded">
                Create New Report
            </button></a>
        </div>

        </div>
        </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    
                <th scope="col" class="px-6 py-3">
                        {{ __('app.table_no') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Report Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('report.address') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Severity
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Urgency
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Photo
                    </th>

                    <th scope="col" class="px-6 py-3">
                       Edit
                    </th>
                </tr>
            </thead>
            <tbody>

                   @foreach($reports as $key => $report)

                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        {{ $reports->firstItem() + $key }}
                    </td>
                    <td class="px-6 py-4">
                        {!! $report->name_link !!}
                    </td>
                    <td class="px-6 py-4">
                        {{ $report->address }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $report->severity }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $report->urgency }}
                    </td>
                    <td class="px-6 py-4">
                        <img src="{{ asset($report->photo) }}" width= '50' height='50' class="img img-responsive" />
                    </td>
                    <td class="px-6 py-4">
                         <a href="{{ route('reports.show', $report) }}" id="show-report-{{ $report->id }}">										{{ __('app.show') }}
                         </a>
                    </td>
                </tr>
@endforeach
            </tbody>
        </table>
            <div class="card-body">{{ $reports->appends(Request::except('page'))->render() }}</div>
    </div>

    <script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>
</div>
</div>

<br><br>
@endsection