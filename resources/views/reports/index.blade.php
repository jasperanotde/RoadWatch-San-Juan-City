
@extends('layout.layout')

@section('title', __('report.list'))

@section('content')

    <section class="mx-20">
        <div class="my-20 relative rounded" id="mapid">
            <button class="absolute bottom-0 bg-primary text-white p-2 rounded hover:bg-secondary m-2 z-[1000]" id="myButton">My Location</button>
        </div> 
    </section>

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
   integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
   crossorigin=""/>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.9.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.9.1/dist/MarkerCluster.Default.css" />
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
<script src="https://unpkg.com/leaflet.markercluster@1.9.1/dist/leaflet.markercluster.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

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

    map.on('click', function(e) {
        let latitude = e.latlng.lat.toString().substring(0, 15);
        let longitude = e.latlng.lng.toString().substring(0, 15);

        if (theMarker != undefined) {
            map.removeLayer(theMarker);
        };

        var popupContent = "Your location : " + latitude + ", " + longitude + ".";
        popupContent += '<br><a href="{{ route('reports.create') }}?latitude=' + latitude + '&longitude=' + longitude + '">Add new report here</a>';

        theMarker = L.marker([latitude, longitude]).addTo(map);
        theMarker.bindPopup(popupContent)
        .openPopup();
    });
    @endcan

 


</script>
@endpush


<div class="mt-4 mb-3">
    <div class="float-middle">
        @can('create', new App\Models\Report)
            <a href="{{ route('reports.create') }}" style="background: green; margin-bottom:" class="btn btn-success">Create New Report</a>
        @endcan
    </div>
    <h1 class="text-black page-title">Reports <small>{{ __('app.total') }} : {{ $reports->total() }} Reports </small></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="control-label">Search Report</label>
                        <input placeholder="{{ __('report.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" style="background: green;" value="Search Report" class="btn btn-secondary">
                    <a href="{{ route('reports.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>Report Name</th>
                        <th>{{ __('report.address') }}</th>
                        <th>Severity</th>
                        <th>Urgency</th>
                        <th>Photo</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $key => $report)
                    <tr>
                        <td class="text-center">{{ $reports->firstItem() + $key }}</td>
                        <td>{!! $report->name_link !!}</td>
                        <td>{{ $report->address }}</td>
                        <td>{{ $report->severity }}</td>
                        <td>{{ $report->urgency }}</td>
                        <td><img src="{{ asset($report->photo) }}" width= '50' height='50' class="img img-responsive" /></td>


                        <td class="text-center">
                            <a href="{{ route('reports.show', $report) }}" id="show-report-{{ $report->id }}">{{ __('app.show') }}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $reports->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection
