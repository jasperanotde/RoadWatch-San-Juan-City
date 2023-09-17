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
 <!-- Display existing report details here -->
<br>

<!-- Modal toggle -->
    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="block text-white bg-primary hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    Create Action Slip
    </button>
    <br>

    @foreach ($report->submissions as $submission)
    <div class="border rounded-lg shadow-lg p-6">
        <div class="submission">
            <p>{{ $submission->new_field }}</p>
            <p>{{ $submission->date }}</p>
            <p>{{ $submission->location }}</p>
<<<<<<< HEAD
            <p>Materials:</p>
            <ul>
                <!-- removing array brackets -->
                @foreach (json_decode($submission->materials) as $material)
                    <li>- {{ $material }}</li>
                @endforeach
            </ul>
               <p>Personnel:</p>
            <ul>
            @if (!is_null($submission->personnel))
                    @foreach (json_decode($submission->personnel) as $person)
                        <li>- {{ $person }}</li>
                    @endforeach
                @endif           
            </ul>
        <ul>
            @foreach ($submission->actionsTakenArray() as $action)
                <li>
                    <input type="checkbox" disabled {{ in_array($action, $submission->actionsTakenArray()) ? 'checked' : '' }}>
                    {{ $action }}
                </li>
            @endforeach
        </ul>  
=======
            <p>{{ $submission->materials }}</p>
            <p>{{ $submission->personnel }}</p>
            <p>Actions Taken:</p>
            <ul>
                @foreach ($submission->actionsTakenArray() as $action)
                    <li>
                        <input type="checkbox" disabled {{ in_array($action, $submission->actionsTakenArray()) ? 'checked' : '' }}>
                        {{ $action }}
                    </li>
                @endforeach
            </ul>  
>>>>>>> 628ec9cdde49e6d958151a188ab5ca543a6cd345
        <p>{{ $submission->remarks }}</p>
        <button data-modal-target="delete-modal" data-modal-toggle="delete-modal" type="submit" class="btn btn-danger">Delete Submission</button>
        </div>
    </div>

<!-- delete modal -->
<div style="width:80%; margin: 0 auto;" id="delete-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">

<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>

            <div class="px-6 py-6 lg:px-8">
                <h3  style="text-align: center; padding-top: 10px;" class="mt-4 text-xl font-medium text-gray-900 dark:text-white">Do you want to delete this record slip?</h3>
            </div>
            <form method="POST" action="{{ route('reports.submissions.delete', ['report' => $report, 'submission' => $submission]) }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="submission_id" value="{{ $submission->id }}">
                <button type="submit" class="btn btn-danger">Yes</button>
            </form>
        </div>
</div>
@endforeach

<!-- Main modal (create forms of record slip) -->
<div style="width:80%; margin: 0 auto;" id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden  p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full  max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3  style="text-align: center; padding-top: 10px;" class="mt-4 text-xl font-medium text-gray-900 dark:text-white">Action Slip Form</h3>

                <form method="POST" action="{{ route('reports.submit', $report) }}" class="space-y-6">
    		@csrf

                    <div>
                        <label for="new_field" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input
                            type="text"
                            name="new_field"
                            id="new_field"
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="name@company.com"
                            value="{{ $report->name }}"
                            readonly
                        >                    
                    </div>
        <div>
            <label for="date" class="block text-sm font-medium text-gray-900 dark:text-white">Date</label>
            <input type="date" name="date" id="date" required
                class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
        </div>

        <div>
            <label for="location" class="block text-sm font-medium text-gray-900 dark:text-white">Location</label>
            <input
                type="text"
                name="location"
                id="location"
                required
                class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                placeholder="Enter Location"
                value="{{ $report->address }}"
                readonly
            >
        </div>

        <div>
            <label for="materials" class="block text-sm font-medium text-gray-900 dark:text-white">Materials</label>
            <div id="materials-container">
                <div class="mb-2">
                    <input
                        type="text"
                        name="materials[]"
                        class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        placeholder="Enter Materials"
                        required
                    >
                </div>
            </div>
    <button type="button" id="add-material" class="text-blue-500 hover:underline focus:outline-none">
        Add Material
    </button>
        </div>

        <div>
        <label for="personnel" class="block text-sm font-medium text-gray-900 dark:text-white">Personnel</label>
            <div id="personnel-container">
                    <input
                        type="text"
                        name="personnel[]"
                        class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        placeholder="Enter Personnel"
                        required
                     >
            </div>
            <button type="button" id="add-personnel" class="text-blue-500 hover:underline focus:outline-none">
                    Add Personnel
                    </button>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-900 dark:text-white">Actions Taken</label>
            <div class="space-y-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="actions_taken[]" value="Action 1"
                        class="form-checkbox h-5 w-5 text-blue-600">
                    <span class="ml-2 text-gray-900 dark:text-white">Action 1</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="actions_taken[]" value="Action 2"
                        class="form-checkbox h-5 w-5 text-blue-600">
                    <span class="ml-2 text-gray-900 dark:text-white">Action 2</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="actions_taken[]" value="Action 3"
                        class="form-checkbox h-5 w-5 text-blue-600">
                    <span class="ml-2 text-gray-900 dark:text-white">Action 3</span>
                </label>
                <!-- Add more checkboxes as needed -->
            </div>
        </div>

        <div>
            <label for="remarks" class="block text-sm font-medium text-gray-900 dark:text-white">Remarks</label>
            <textarea name="remarks" id="remarks" rows="4"
                class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                placeholder="Enter Remarks"></textarea>
        </div>
                <br>
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            
                </form>
                <br>
            </div>
        </div>
    </div>
</div> 
<<<<<<< HEAD
=======

>>>>>>> 628ec9cdde49e6d958151a188ab5ca543a6cd345
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

        document.addEventListener("DOMContentLoaded", function () {
        const materialsContainer = document.getElementById("materials-container");
        const addMaterialButton = document.getElementById("add-material");

        addMaterialButton.addEventListener("click", function () {
            const materialInput = document.createElement("div");
            materialInput.innerHTML = `
                <div class="mb-2">
                    <input
                        type="text"
                        name="materials[]"
                        class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        placeholder="Enter Materials"
                        required
                    >
                </div>
            `;
            materialsContainer.appendChild(materialInput);
        });

const addPersonnelButton = document.getElementById("add-personnel");
const personnelContainer = document.getElementById("personnel-container");

addPersonnelButton.addEventListener("click", function () {
    const personnelInput = document.createElement("div");
    personnelInput.innerHTML = `
        <div class="mb-2">
            <input
                type="text"
                name="personnel[]"
                class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                placeholder="Enter Personnel"
                required
            >
        </div>
    `;
    personnelContainer.appendChild(personnelInput);
});

        
    });
</script>
@endpush
