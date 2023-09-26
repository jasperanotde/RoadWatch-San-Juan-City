<form action="{{ route('reports.finishedReport', $report->id) }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div data-te-modal-init class="bg-black bg-opacity-50 fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" id="finishedModal" tabindex="-1" aria-modal="true" role="dialog">
        <div data-te-modal-dialog-ref class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
            <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none ">
                <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    <!--Modal title-->
                    <h5 class="text-xl font-medium leading-normal">
                    Mark as done Report: {{ $report->name }}
                    </h5>
                </div>
                <!--Modal body-->
                <div class="p-4">
                    <div class="p-2 w-full">
                        <div class="relative">
                        <label for="photo" class="leading-7 text-sm text-gray-600">Select updated photo of the Report</label>
                        <input
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            name="finished_photo[]"
                            type="file"
                            id="photo"
                            multiple>
                            <div class="px-4 py-4 bg-gray-100 hover:bg-gray-200" id="newImagesContainer" hidden>
                                <div class="block text-sm font-medium text-gray-600">
                                    Updated Images of the Report to mark as Done
                                    <div class="flex items-center place-content-center">
                                        <div id="photoPreviews"></div>
                                    </div>
                                </div>
                            </div>
                            {!! $errors->first('photo', '<span class="text-red-500 text-sm">:message</span>') !!}
                        </div>
                    </div>
                </div>
                <!--Modal footer-->
                <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4">
                    <button type="button" class="mr-2 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-md" data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                        Cancel
                    </button>
                    <input type="hidden" name="reportId" value="{{ $report->id }}">
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md" data-te-ripple-init data-te-ripple-color="light">
                        Mark as Done
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
