@extends('layout.layout')

@section('title', __('report.list'))

@section('content')
<div class="mx-5 md:mx-10 lg:mx-20">
    <div class="mt-20 mb-10 relative rounded z-0" id="mapid">
        <button class="absolute bottom-0 bg-primary text-white p-2 rounded hover:bg-secondary m-2 z-[1000]" id="myButton">My Location</button>
    </div> 

    @section('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
        <style>
            #mapid { 
                min-height: 500px;
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

        // Getting user location and max radius (500 meter)
        var marker, circle, lat, long, accuracy;
        var featureGroup;

        function getPosition(position) {
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
            circle = L.circle([lat, long], { radius: 500 })

            featureGroup = L.featureGroup([marker, circle]).addTo(map)
            console.log("Your coordinate is: Lat: " + lat + " Long: " + long + " Accuracy: " + accuracy)

            // Set a custom zoom level when getting user's location
            // map.setView([lat, long], 10); // Adjust the zoom level (15 in this example)
        }

        //Get back to user location
        document.getElementById('myButton').addEventListener('click', function() {
                if(featureGroup) {
                    map.fitBounds(featureGroup.getBounds())
                }
                event.stopPropagation();
            });
    
        // Create a marker cluster group with appropriate maxClusterRadius
        var markers = L.markerClusterGroup({
        maxClusterRadius: 50 // Adjust this value to control when clustering occurs
        });

        // Make an asynchronous GET request to the API endpoint
        axios.get('{{ route('api.reports.index') }}')
        .then(function (response) {
            // Extract GeoJSON features from the response data
            var geojsonFeatures = response.data.features;

            // Loop through each GeoJSON feature
            geojsonFeatures.forEach(function (feature) {
            // Decode the JSON-encoded photo path
            var photos = JSON.parse(feature.properties.photo);

            // Get the first photo
            var firstPhoto = photos[0];

            // Create a custom icon for the marker
            var customIcon = L.icon({
                iconUrl: firstPhoto, // Use the photo URL for the image URL
                iconSize: [35, 35], // Customize icon size if needed
                className: 'custom-pin' // Add your custom CSS class
            });

            // Create a marker with the custom icon and bind a popup
            var marker = L.marker(
                [feature.geometry.coordinates[1], feature.geometry.coordinates[0]],
                { icon: customIcon }
            ).bindPopup(feature.properties.map_popup_content);

            // Add the marker to the marker cluster group
            markers.addLayer(marker);
            });

            // Add the main marker cluster group to the map
            map.addLayer(markers);
        })
        .catch(function (error) {
            console.error(error); // Log any errors to the console
        });

        // Sattelite layer
        var satelliteLayer = L.tileLayer('http://mt0.google.com/vt/lyrs=s&hl=en&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });
        var baseMaps = {
            "Street": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'),
            "Satellite": satelliteLayer
        };
        L.control.layers(baseMaps).addTo(map);

        // Manually Pin on Map to create report
        @can('create', new App\Models\Report)
        var theMarker;
        var geocoder = L.Control.Geocoder.nominatim();

        map.on('click', function(e) {
            let latitude = e.latlng.lat.toString().substring(0, 15);
            let longitude = e.latlng.lng.toString().substring(0, 15);

            if (theMarker != undefined) {
                map.removeLayer(theMarker);
            }

            geocoder.reverse(e.latlng, map.options.crs.scale(map.getZoom()), function(results) {
            var address = results[0] ? results[0].name : "Address not found";
            var popupContent = "Your location: " + address;
            popupContent += '<br><a href="{{ route('reports.create') }}?latitude=' + latitude + '&longitude=' + longitude + 
            '&address=' + address + '">Add new report here</a>';

            theMarker = L.marker(e.latlng).addTo(map);
            theMarker.bindPopup(popupContent).openPopup();

            // Remove the marker after 5 seconds
                setTimeout(function() {
                    if (theMarker) {
                        map.removeLayer(theMarker);
                    }
                }, 5000);
            });
        });
        @endcan

    function updateTable(category, button) {
        // Hover state when Clicked
        var buttons = document.querySelectorAll('ul li a');
        buttons.forEach(function (btn) {
            btn.classList.remove('active', 'text-blue-600', 'border-b-2', 'border-blue-600', 'rounded-t-lg');
        });

        // Add the "active-tab" class to the clicked button
        button.classList.add('active', 'text-blue-600', 'border-b-2', 'border-blue-600', 'rounded-t-lg');

        // Add CSRF protection header.
        var header = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};

        if (category.toUpperCase() === "ALL") {
        window.location.href = '/reports'; // Redirect to reports.index
        return; // Exit the function
        }

        // Make an Ajax request to the server to get the list of reports for the specified status.
        var request = new XMLHttpRequest();
        request.open('GET', '/reports/report/' + category.toUpperCase());
        request.setRequestHeader('X-CSRF-TOKEN', header['X-CSRF-TOKEN']);

        request.onload = function() {
            if (request.status === 200) {
            // The request was successful.
            var responseData = JSON.parse(request.responseText);
            var reports = responseData.reports; // Extract reports array from response
            var count = responseData.count; // Extract count from response
            var user = responseData.user;

            // Update the table with the new data.
            var tableBody = document.querySelector('table tbody');
            tableBody.innerHTML = '';
            
            var rowNumber = 1;

            for (var i = 0; i < reports.length; i++) {
                var report = reports[i];

                // Create a new table row for the report.
                var row = document.createElement('tr');
                row.classList.add('bg-white', 'border-b', 'hover:bg-gray-50')

                // Create a new table cell for each field of the report.
                var idCell = document.createElement('td');
                idCell.classList.add('px-6', 'py-4');
                idCell.textContent = rowNumber;
                rowNumber++;

                var nameCell = document.createElement('td');
                nameCell.classList.add('px-6', 'py-4');
                nameCell.innerHTML = report.name;

                var addressCell = document.createElement('td');
                addressCell.classList.add('px-6', 'py-4');
                addressCell.textContent = report.address;

                var severityCell = document.createElement('td');
                severityCell.classList.add('px-6', 'py-4');
                severityCell.textContent = report.severity;

                var urgencyCell = document.createElement('td');
                urgencyCell.classList.add('px-6', 'py-4');
                urgencyCell.textContent = report.urgency;

                var photoCell = document.createElement('td');
                photoCell.classList.add('px-6', 'py-4');
                if (report.photo !== null) {
                    var images = JSON.parse(report.photo); // Parse the JSON-encoded data to an array of image paths.

                    if (images.length > 0) {
                        // Create a div element to hold the images.
                        var imageContainer = document.createElement('div');

                        for (var j = 0; j < images.length; j++) {
                            // Create an image element for each image URL.
                            var imgElement = document.createElement('img');
                            imgElement.src = images[0]; // Use the image URL directly.
                            imgElement.width = 50;
                            imgElement.height = 50;
                            imgElement.className = 'img img-responsive';

                            // Append the image element to the image container.
                            imageContainer.appendChild(imgElement);
                        }

                        // Append the image container to the cell.
                        photoCell.appendChild(imageContainer);
                    } else {
                        photoCell.textContent = 'No photo';
                    }
                } else {
                    photoCell.textContent = 'No photo';
                }

                var statusCell = document.createElement('td');
                statusCell.classList.add('px-6', 'py-4');

                // Create a new div element.
                var statusDiv = document.createElement('div');
                statusDiv.classList.add('font-bold');
                statusDiv.textContent = report.status;
                statusCell.appendChild(statusDiv);

                switch (report.status) {
                    case 'PENDING':
                        statusDiv.classList.add('text-yellow-400');
                        break;
                    case 'INPROGRESS':
                        statusDiv.classList.add('text-blue-500');
                        break;
                    case 'FINISHED':
                        statusDiv.classList.add('text-green-500');
                        break;
                    case 'DECLINED':
                        statusDiv.classList.add('text-red-500');
                        break;
                    default:
                }
        
                var editCell = document.createElement('td');
                var routeUrl = '/reports/' + report.id;

                // Create a new editLink element
                var editLink = document.createElement('a');
                editLink.href = routeUrl; //
                editLink.textContent = '{{ __('app.show') }}';

                // Append the editLink to the editCell
                editCell.innerHTML = ''; // Clear the existing content
                editCell.appendChild(editLink);


                // Append the table cells to the table row.
                row.appendChild(idCell);
                row.appendChild(nameCell);
                row.appendChild(addressCell);
                row.appendChild(severityCell);
                row.appendChild(urgencyCell);
                row.appendChild(photoCell);
                row.appendChild(statusCell);
                row.appendChild(editCell);


                // Append the table row to the table body.
                tableBody.appendChild(row);
                console.log('Reports length:', reports.length);
            }
        }

        var countElement = document.getElementById('count-display');
        if (countElement) {
            var report = null;
            for (var r = 0; r < reports.length; r++) {
                report = reports[r];
            }
            
            if (report !== null) {
                if (user.id === report.creator_id && category.toUpperCase() === 'MY_REPORTS' && count > 0) {
                    countElement.textContent = count + ' My Reports';
                } else if (user.id === report.assigned_user_id && category.toUpperCase() === 'ASSIGNED' && count > 0) {
                    countElement.textContent = count + ' Assigned Reports';
                } else if (category.toUpperCase() === 'FINISHED' || category.toUpperCase() === 'PENDING' || category.toUpperCase() === 'INPROGRESS' || category.toUpperCase() === 'DECLINED') {
                    var formattedStatus = report.status.charAt(0).toUpperCase() + report.status.slice(1).toLowerCase();
                    countElement.textContent = count + ' ' + formattedStatus + ' Reports';
                } else {
                    countElement.textContent = 'No Reports';
                }
            } else {
                countElement.textContent = 'No Reports';
            }
        }
    };
    request.send();
};

window.onload = function() {
    // Get a reference to the element you want to scroll to
    var datatable = document.getElementById('reportTable');

    // Check if the element exists
    if (datatable) {
        // Scroll to the element using the `scrollIntoView` method
        datatable.scrollIntoView({ behavior: 'smooth' }); // You can use 'auto' or 'smooth' for scrolling behavior
    }
};


</script>
@endpush

<div class="max-w-6xl mx-auto" id="reportTable"> 

     <div class="flex justify-between items-center">
        <h1 class="font-josefinsans font-bold flex-grow text-xl md:text-2xl lg:text-4xl font-normal leading-none tracking-tight font-poppins text-primary"><span class="font-josefinsans font-bold underline underline-offset-3 decoration-7 decoration-secondary">{{ __('app.total') }}: <small><span id="count-display">{{ $reports->total() }} Total Reports </span> </span></small></h1>
    </div>

    <div class="mb-20 overflow-x-auto shadow-md sm:rounded-lg">
        <div class="p-4">
            <label for="datatable-search-input" class="sr-only">Search</label>
            <div class="flex flex-col items-center mt-1 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center">
                    <div class="pl-3 pointer-events-none mr-5">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="search" id="datatable-search-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full w-3/4 sm:w-10/12 md:5/6 pl-10 p-2.5" placeholder="Search for items">
                </div>
                <div class="mt-5 sm:mt-0">
                    <label for="reportFilter" class="mr-2 mt-2 sm:mt-0">Filter Reports</label>
                    <select id="reportFilter" onchange="updateTable(this.value, this)" class="cursor-pointer border rounded-lg hover:text-gray-600 hover:border-gray-300">
                        <option value="all">All Reports</option>
                        <option value="my_reports">My Reports</option>
                        @if(auth()->check() && $assignedReports->count() > 0)
                            <option value="assigned">Assigned Reports</option>
                        @endif
                        <option value="pending">Pending</option>
                        <option value="inprogress">Inprogress</option>
                        <option value="finished">Finished</option>
                        <option value="declined">Declined</option>
                    </select>
                </div>
            </div>
        </div>
        <div style="padding: 14px;" id="datatable">
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
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $key => $report)
                    <tr class="bg-white border-b hover:bg-gray-50">
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
                        @if (!is_null($report->photo))
                            @foreach (json_decode($report->photo) as $image)
                                <img src="{{ asset($image) }}" width="50" height="50" class="img img-responsive" />
                                @break
                            @endforeach
                        @else
                            {{ __('report.no_photo') }}
                        @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="status-label font-bold">{{ $report->status }}</div>
                        </td>
                        <td class="px-6 py-4" data-image="{{ $report->getPhoto() }}">
                            <a href="{{ route('reports.show', ['report' => $report]) }}">
                                {{ __('app.show') }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="">
            <a href="{{ route('reports.create') }}">
                <button class="bg-primary text-white p-2 rounded hover:bg-secondary m-2 font-bold py-2 px-4 rounded">
                    Create Report
                </button></a>
            </div>
        </div>
            <div class="card-body">{{ $reports->appends(Request::except('page'))->render() }}</div>
        </div>
        <script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>
    </div>
</div>
@endsection
