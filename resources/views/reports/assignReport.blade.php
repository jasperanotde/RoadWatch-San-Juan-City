<form action="{{ route('approve.report', $report->id) }}" method="POST" enctype="muiltipart/form-data">
    {{ csrf_field() }}
    <div data-te-modal-init class="bg-black bg-opacity-50 fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" id="assignModal" tabindex="-1" aria-modal="true" role="dialog">
        <div data-te-modal-dialog-ref class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
            <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none ">
                <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    <!--Modal title-->
                    <h5 class="text-xl font-medium leading-normal">
                    Approve and Assignment of Report
                    </h5>
                </div>
                <!--Modal body-->
                <div class="p-4">
                    <div class="mb-4">
                        <span class="font-semibold">
                            Basis for Report Approval 
                        </span>
                        <ul class="list-disc ml-10">
                            <li>Accurate Information</li>
                            <li>Photographic Evidence</li>
                            <li>Safety Concerns</li>
                            <li>Relevance to Prioritization</li>
                            <li>Compliance with Standards</li>
                        </ul>
                    </div>

                    <div class="flex justify-between space-x-4 mb-10 mx-4">
                        <div class="relative h-11 w-1/4 min-w-[200px]">
                            <label for="start-date" class="block text-sm font-medium text-gray-900 ">Start Date</label>
                                <input type="date" name="start-date" id="start-date" required
                                    class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 ">
                        </div>

                        <div class="relative h-11 w-1/4 min-w-[200px]">
                            <label for="target-date" class="block text-sm font-medium text-gray-900 ">Target End Date</label>
                                <input type="date" name="target-date" id="target-date" required
                                    class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 ">
                        </div>
                    </div>
                    
                    <div class="mb-4 font-semibold">
                        <label for="assignedUser">Assign to City Engineer user:</label>
                    </div>
                   
                    <select name="assignedUser" id="assignedUser" class="w-full py-2 px-3 border rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:ring-blue-500">
                        @foreach ($cityEngineers as $engineer)
                            <option class="text-primary" value="{{ $engineer->id }}">{{ $engineer->name }} (Assigned Reports: {{ $engineer->report_count }})</option>
                        @endforeach
                    </select>
                </div>
                <!--Modal footer-->
                <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4">
                    <button type="button" class="mr-2 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-md" data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                        Cancel
                    </button>
                    <input type="hidden" name="reportId" value="{{ $report->id }}">
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md" data-te-ripple-init data-te-ripple-color="light">
                        Assign
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
