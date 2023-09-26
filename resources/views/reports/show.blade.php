@extends('layout.layout')
@section('title', __('report.detail'))

@section('content')
<div id="reports-container" class="flex justify-center m-20">
    <div class="flex w-full max-w-screen-xl">
        <!-- Left Side (Report Details) -->
        <div class="w-1/2 p-4">
            <div style="border-radius: 10px" id="glass" class="glass border shadow-lg ">
                <div style="background: rgba(17,63,103); border-top-left-radius: 8px; border-top-right-radius: 8px;" class="text-white rounded-sm p-4">
                    <h1 class="text-xl font-bold text-white">Report Details</h1>
                </div>
                <table class="table-auto">
                    <tbody>
                        <tr class="bg-blue-100 hover:bg-blue-200 border-b">
                            <td  class="px-6 py-4 w-2/5 border-r">Report Name : </td>
                            <td  class="px-6 py-4 w-3/5 bg-gray-100 hover:bg-gray-200">{{ $report->name }}</td>
                        </tr>
                        <tr class="bg-blue-100 hover:bg-blue-200 border-b">
                            <td class="px-6 py-4 w-2/5 border-r">Report Address : </td>
                            <td class="px-6 py-4 w-3/5 bg-gray-100 hover:bg-gray-200">{{ $report->address }}</td>
                        </tr>
                        <tr class="bg-blue-100 hover:bg-blue-200 border-b">
                            <td class="px-6 py-4 w-2/5 border-r">Details : </td>
                            <td class="px-6 py-4 w-3/5 bg-gray-100 hover:bg-gray-200">{{ $report->details }}</td>
                        </tr>
                        <tr class="bg-blue-100 hover:bg-blue-200 border-b">
                            <td class="px-6 py-4 w-2/5 border-r">Photo : </td>
                            <td class="flex items-center place-content-center px-4 py-4 bg-gray-100 hover:bg-gray-200">
                                @if (!is_null($report->photo))
                                    @foreach (json_decode($report->photo) as $image)
                                        <a href="{{ asset($image) }}" data-fancybox="gallery" class="mr-4">
                                            <img src="{{ asset($image) }}" width="100" height="100" class="rounded-lg border-solid border-2 border-primary img img-responsive" />
                                            </a>
                                        @endforeach
                                @else
                                    {{ __('report.no_photo') }}
                                @endif
                            </td>
                        </tr>
                        <tr class="bg-blue-100 hover:bg-blue-200 border-b">
                            <td class="px-6 py-4 w-2/5 border-r">Severity : </td>
                            <td class="px-6 py-4 w-3/5 bg-gray-100 hover:bg-gray-200">{{ $report->severity }}</td>
                        </tr>
                        <tr class="bg-blue-100 hover:bg-blue-200 border-b">
                            <td class="px-6 py-4 w-2/5 border-r">Urgency :</td>
                            <td class="px-6 py-4 w-3/5 bg-gray-100 hover:bg-gray-200">{{ $report->urgency }}</td>
                        </tr>
                        <tr class="bg-blue-100 hover:bg-blue-200 border-b">
                            <td class="px-6 py-4 w-2/5 border-r">Status :</td>
                            <td class="items-center px-6 py-4 w-3/5 bg-gray-100 hover:bg-gray-200 font-bold">
                                <div class="inline-block mr-2 status-label">{{ $report->status }}</div>
                                <!-- IF APPROVED AND IN PROGRESS -->
                                @if (!auth()->user()->hasRole(['City Engineer', 'Normal User']))
                                    @if ($report->status === 'PENDING')
                                        <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md"
                                            type="button" 
                                            data-te-target="#assignModal" 
                                            data-te-toggle="modal" 
                                            data-te-ripple-init 
                                            data-te-ripple-color="light">Approve</button>

                                        <button class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md"
                                            type="button" 
                                            data-te-target="#declineModal" 
                                            data-te-toggle="modal" 
                                            data-te-ripple-init 
                                            data-te-ripple-color="light">Decline</button>
                                    @elseif($report->status === 'INPROGRESS')
                                        <button class="px-4 py-2 bg-green-400 hover:bg-green-500 text-white text-sm font-medium rounded-md"
                                            type="button" 
                                            data-te-target="#finishedModal" 
                                            data-te-toggle="modal" 
                                            data-te-ripple-init 
                                            data-te-ripple-color="light">Mark as Done</button>
                                            @if ($report->assignedUser)
                                                <span class="italic font-normal"><strong>Assigned to:</strong> {{ $report->assignedUser->name }}</span>
                                            @else
                                                <span>Not assigned yet</span>
                                            @endif
                                    @else
                                        <!-- NO BUTTON -->
                                    @endif
                                @endif

                                @if(auth()->user()->hasRole('City Engineer'))
                                    @if($report->status === 'INPROGRESS')
                                        <button class="px-4 py-2 bg-green-400 hover:bg-green-500 text-white text-sm font-medium rounded-md"
                                            type="button" 
                                            data-te-target="#finishedModal" 
                                            data-te-toggle="modal" 
                                            data-te-ripple-init 
                                            data-te-ripple-color="light">Mark as Done</button>
                                    @endif
                                @endif
                            </td>
                            <!-- APPROVE THE REPORT -->
                            @include('reports.assignReport')

                            <!-- DECLINE THE REPORT -->
                            <form action="{{ route('reports.declineReport', $report->id)  }}" method="POST" enctype="muiltipart/form-data">
                                {{ csrf_field() }}
                                <div data-te-modal-init class="bg-black bg-opacity-50 fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" id="declineModal" tabindex="-1" aria-modal="true" role="dialog">
                                    <div data-te-modal-dialog-ref class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
                                        <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                                            <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                                                <!--Modal title-->
                                                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200">
                                                Decline Report
                                                </h5>
                                            </div>
                                            <!--Modal body-->
                                            <div class="relative p-4">
                                                <p>Are you sure you want to decline the selected report?</p>
                                            </div>
                                            <!--Modal footer-->
                                            <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                                                <button type="button" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-md" data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                                                    Cancel
                                                </button>
                                                <input type="hidden" name="report_id" value="{{ $report->id }}">
                                                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white ml-2 rounded-md" data-te-ripple-init data-te-ripple-color="light">
                                                    Decline
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- MARK AS FINISHED THE REPORT -->
                            @include('reports.finishedReport')
                        </tr>
                        @if($report->status === 'FINISHED')
                        <tr class="bg-blue-100 hover:bg-blue-200 border-b">
                            <td class="px-6 py-4 w-2/5 border-r">Updated Photo : </td>
                            <td class="flex items-center place-content-center px-4 py-4 bg-gray-100 hover:bg-gray-200">
                                @if (!is_null($report->finished_photo))
                                    @foreach (json_decode($report->finished_photo) as $image)
                                        <a href="{{ asset($image) }}" data-fancybox="gallery" class="mr-4">
                                            <img src="{{ asset($image) }}" width="100" height="100" class="rounded-lg border-solid border-2 border-primary img img-responsive" />
                                            </a>
                                        @endforeach
                                @else
                                    {{ __('report.no_photo') }}
                                @endif
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="flex items-center justify-between p-4">
                    @if(auth()->user()->hasRole(['Normal User', 'Admin']))
                        @can('update', $report)
                        @if(auth()->check() && auth()->user()->id === $report->creator_id)
                            <a href="{{ route('reports.edit', ['report' => $report, 'image' => $report->getPhoto()]) }}" id="edit-report-{{ $report->id }}" class="float-right mt-1 mx-2 md:mt-4 md:mx-3 px-4 py-1.5 md:px-9 md:py-2.5 bg-primary text-white text-xxs md:text-xs font-poppins font-normal rounded hover:bg-secondary hover:text-white focus:outline-none focus:bg-primary transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300">Edit Report</a>
                        @endif
                        @endcan
                    @endif
                    @if(auth()->check())
                        <a href="{{ route('reports.index') }}" class=" mt-1 mx-2 md:mt-4 md:mx-3 px-4 py-1.5 md:px-9 md:py-2.5 bg-white text-primary text-xxs md:text-xs font-poppins font-normal rounded hover:bg-secondary hover:text-white focus:outline-none focus:bg-primary transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300 hover:underline">Back to Reports</a>
                    @else
                        <a href="{{ route('report_map.index') }}" class="text-indigo-700 hover:underline">{{ __('report.back_to_index') }}</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Side (Map) -->
        <div class="w-1/2 p-4 ">
            <div style="background: rgba(17,63,103); border-top-left-radius: 8px; border-top-right-radius: 8px;" class="text-white rounded-sm p-4">
                <h1 class="text-xl font-bold text-white">{{ trans('report.location') }}</h1>
            </div>
            @if ($report->coordinate)
                <div style=" border-bottom-right-radius: 8px;  border-bottom-left-radius: 8px;" id="mapid" class="border shadow-lg h-80 z-0"></div>
            @else
                <p>{{ __('report.no_coordinate') }}</p>
            @endif
            @if(auth()->user()->id === $report->creator_id)
                <div class="my-5">
                    <label for="remarks" class="block text-sm font-medium text-gray-900 ">Report Remarks</label>
                    <textarea name="remarks" id="remarks" rows="4"
                        class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 "
                        placeholder="Enter Remarks"></textarea>
                </div>
            @endif
        </div>
    </div>
</div>

@role('Admin|City Engineer Supervisor|City Engineer')
<!------- Record Slip Index ------->
<div id="" class="flex justify-center m-20 rounded-lg">
    <div class="w-full shadow-lg max-w-screen-xl">
        <div style="background: rgba(17,63,103); border-top-left-radius: 8px; border-top-right-radius: 8px; display: flex; justify-content: space-between; align-items: center;" class="text-white rounded-sm p-4">
            <h1 class="text-xl font-bold text-white">Action Slips</h1>
                <!-- Modal toggle -->
            <button class="float-right block mt-1 mx-2 md:mt-4 md:mx-3 px-4 py-1.5 md:px-9 md:py-2.5 bg-white text-primary text-xxs md:text-xs font-poppins font-normal rounded hover:bg-secondary hover:text-white focus:outline-none focus:bg-primary transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300" type="button" data-te-target="#authentication-modal" data-te-toggle="modal" data-te-ripple-init data-te-ripple-color="light">
                Create Action Slip <span style="font-size: 18px; font-weight: bold; margin-left: 5px;">+</span>
            </span>
        </div>
        
        <div class="submission">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-md text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($report->submissions as $submission)
                    <tr class="bg-blue-100 border-b">
                        <!-- Show Button -->
                        <td class="px-5 py-4 w-full border-r">
                            <button data-te-target="#showModal{{ $submission->id }}" data-te-toggle="modal" class="underline text-green-800" type="button" data-te-ripple-init data-te-ripple-color="light">{{ $submission->date }}</button>
                        </td>  
                        <!-- Delete Button -->
                        @can('report-delete')
                        <td class="px-5 py-4 w-1/2 bg-red-100 hover:bg-gray-200">
                            <button class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md" data-te-toggle="modal" data-te-target="#deleteModal{{ $submission->id }}" data-te-ripple-init data-te-ripple-color="light" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"/>
                                </svg>
                                Delete
                            </button>
                            <!------- Record Slip Delete Modal ------->
                            <form action="{{ route('reports.submissions.delete', ['report' => $report, 'submission' => $submission])  }}" method="POST" enctype="muiltipart/form-data">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                                <div data-te-modal-init class="bg-black bg-opacity-50 fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" id="deleteModal{{ $submission->id }}" tabindex="-1" aria-modal="true" role="dialog">
                                    <div data-te-modal-dialog-ref class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
                                        <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                                            <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                                                <!--Modal title-->
                                                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200">
                                                Delete Action Slip
                                                </h5>
                                            </div>
                                            <!--Modal body-->
                                            <div class="relative p-4">
                                                <p>Are you sure you want to delete action slip?</p>
                                            </div>
                                            <!--Modal footer-->
                                            <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                                                <button type="button" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-md" data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                                                    Cancel
                                                </button>
                                                <input type="hidden" name="submission_id" value="{{ $submission->id }}">
                                                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white ml-2 rounded-md" data-te-ripple-init data-te-ripple-color="light">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>
                        @endcan
                        <!-- End of Record Slip Index -->

                        <!-- New Record Slip Show Modal -->
                        <div data-te-modal-init class="bg-black bg-opacity-50 fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" data-te-modal-init id="showModal{{ $submission->id }}"  tabindex="-1" aria-hidden="true" role="dialog">
                            <div data-te-modal-dialog-ref class="relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
                                <!-- Modal content -->
                                <div class="relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                                    <!-- Modal header/Title -->
                                    <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                                        <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200" id="exampleModalCenterTitle">
                                        Show Action Slip
                                        </h5>
                                        <!--Close button-->
                                        <button type="button" class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none" data-te-modal-dismiss aria-label="Close">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="relative flex-auto p-4">
                                        <div class="submission">
                                            <div class="mb-3">
                                                <p><strong>Report Name:</strong>
                                                {{ $submission->new_field }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <p><strong>Action Slip Date:</strong>
                                                {{ $submission->date }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <p><strong>Location:</strong>
                                                {{ $submission->location }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <p><strong>Materials:</strong></p>
                                                <ul class="ml-5 list-disc">
                                                    <!-- removing array brackets -->
                                                    @foreach (json_decode($submission->materials) as $material)
                                                        <li>{{ $material }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="mb-3">
                                                <p><strong>Personnel:</strong></p>
                                                <ul class="ml-5 list-disc">
                                                    <!-- removing array brackets -->
                                                    @foreach (json_decode($submission->personnel) as $person)
                                                        <li>{{ $person }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="mb-3">
                                                <p><strong>Actions Taken:</strong></p>
                                                <ul>
                                                    @foreach ($submission->actionsTakenArray() as $action)
                                                        <li>
                                                            <input type="checkbox" disabled {{ in_array($action, $submission->actionsTakenArray()) ? 'checked' : '' }}>
                                                            {{ $action }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="mb-3">
                                                <p><strong>Remarks:</strong>
                                                {{ $submission->remarks }}</p>
                                            </div>
                                            <div class="flex items-center justify-end">
                                                <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white ml-2 rounded-md" data-te-toggle="modal" data-te-target="#deleteModal{{ $submission->id }}" data-te-ripple-init data-te-ripple-color="light" type="button">Delete Action Slip</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endrole


<!-- New Create Action Slip Modal -->
<div data-te-modal-init class="bg-black bg-opacity-50 fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" data-te-modal-init id="authentication-modal"  tabindex="-1" aria-hidden="true" role="dialog">
    <div data-te-modal-dialog-ref class="relative h-[calc(100%-1rem)] w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
        <!-- Modal content -->
        <div class="relative flex max-h-[100%] w-full flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <!-- Modal header/Title -->
            <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200" id="exampleModalCenterTitle">
                Create Action Slip
                </h5>
                <!--Close button-->
                <button type="button" class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none" data-te-modal-dismiss aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="relative overflow-y-auto px-6 py-6 lg:px-8">
                <div class="flex items-center justify-center">
                    <h3 class="mt-4 text-xl font-medium text-gray-900 ">Action Slip Form</h3>
                </div>
                
                <form method="POST" action="{{ route('reports.submit', $report) }}" class="space-y-6">
                @csrf
                    <div>
                        <label for="new_field" class="block mb-2 text-sm font-medium text-gray-900 ">Name</label>
                        <input
                            type="text"
                            name="new_field"
                            id="new_field"
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 "
                            placeholder="name@company.com"
                            value="{{ $report->name }}"
                            readonly
                        >                    
                    </div>
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-900 ">Date</label>
                        <input type="date" name="date" id="date" required
                            class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 ">
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-900 ">Location</label>
                        <input
                            type="text"
                            name="location"
                            id="location"
                            required
                            class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 "
                            placeholder="Enter Location"
                            value="{{ $report->address }}"
                            readonly
                        >
                    </div>

                    <div>
                        <label for="materials" class="block text-sm font-medium text-gray-900 ">Materials</label>
                        <div id="materials-container">
                            <div class="mb-2">
                                <input
                                    type="text"
                                    name="materials[]"
                                    class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 "
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
                        <label for="personnel" class="block text-sm font-medium text-gray-900 ">Personnel</label>
                        <div id="personnel-container">
                            <input
                                type="text"
                                name="personnel[]"
                                class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 "
                                placeholder="Enter Personnel"
                                required
                            >
                        </div>
                        <button type="button" id="add-personnel" class="text-blue-500 hover:underline focus:outline-none">
                                Add Personnel
                        </button>
                    </div>

                    <div class="p-4">
                        <label class="flex mb-5 text-sm font-medium text-gray-900">Actions Taken</label>
                        <div class=" grid grid-cols-2 gap-2 content-center">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="actions_taken[]" value="Declogged"
                                    class="form-checkbox h-5 w-5 text-blue-600">
                                <span class="ml-2 text-gray-900 ">Declogged</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="actions_taken[]" value="Repaired"
                                    class="form-checkbox h-5 w-5 text-blue-600">
                                <span class="ml-2 text-gray-900 ">Repaired</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="actions_taken[]" value="Inspected"
                                    class="form-checkbox h-5 w-5 text-blue-600">
                                <span class="ml-2 text-gray-900 ">Inspected</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="actions_taken[]" value="Painted"
                                    class="form-checkbox h-5 w-5 text-blue-600">
                                <span class="ml-2 text-gray-900 ">Painted</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="actions_taken[]" value="Tree Trimmed/Cut"
                                    class="form-checkbox h-5 w-5 text-blue-600">
                                <span class="ml-2 text-gray-900 ">Tree Trimmed/Cut</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="actions_taken[]" value="Trouble Shoot"
                                    class="form-checkbox h-5 w-5 text-blue-600">
                                <span class="ml-2 text-gray-900 ">Trouble Shoot</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="actions_taken[]" value="Installed"
                                    class="form-checkbox h-5 w-5 text-blue-600">
                                <span class="ml-2 text-gray-900 ">Installed</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="actions_taken[]" value="Others"
                                    class="form-checkbox h-5 w-5 text-blue-600">
                                <span class="ml-2 text-gray-900 ">Others</span>
                            </label>
                            <!-- Add more checkboxes as needed -->
                        </div>
                    </div>
                    <div>
                        <label for="remarks" class="block text-sm font-medium text-gray-900 ">Remarks</label>
                        <textarea name="remarks" id="remarks" rows="4"
                            class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 "
                            placeholder="Enter Remarks"></textarea>
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ">Submit</button>
                </form>
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

// Create the custom icon
var customIcon = L.icon({
    iconUrl: '{{ $firstImageUrl }}', // Replace with your custom icon image URL
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
            <div class="relative mb-2">
                <input
                    type="text"
                    name="materials[]"
                    class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400"
                    placeholder="Enter Materials"
                    required
                >
                <div class="absolute top-1 right-1">
                    <button class="delete-material p-1 h-8 w-7 text-white rounded-lg bg-red-500 hover:bg-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex w-5 h-5 items-center justify-center" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"/>
                        </svg></button>
                </div>
            </div>
        `;

        const deleteMaterialButton = materialInput.querySelector(".delete-material");
        deleteMaterialButton.addEventListener("click", function () {
            materialsContainer.removeChild(materialInput);
        });

        materialsContainer.appendChild(materialInput);
    });

    const addPersonnelButton = document.getElementById("add-personnel");
    const personnelContainer = document.getElementById("personnel-container");

    addPersonnelButton.addEventListener("click", function () {
        const personnelInput = document.createElement("div");
        personnelInput.innerHTML = `
            <div class="relative mb-2">
                <input
                    type="text"
                    name="personnel[]"
                    class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400"
                    placeholder="Enter Personnel"
                    required
                >
                <div class="absolute top-1 right-1">
                    <button class="delete-personnel p-1 h-8 w-7 text-white rounded-lg bg-red-500 hover:bg-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex w-5 h-5 items-center justify-center" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"/>
                        </svg></button>
                </div>
            </div>
        `;

        const deleteButton = personnelInput.querySelector(".delete-personnel");
        deleteButton.addEventListener("click", function () {
            personnelContainer.removeChild(personnelInput);
        });

        personnelContainer.appendChild(personnelInput);
    });
});
</script>
@endpush
