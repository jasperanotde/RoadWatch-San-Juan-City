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
            <form method="POST" action="{{ route('reports.submit', $report) }}" enctype="muiltipart/form-data" class="space-y-6">
               @csrf
               <div>
                  <label for="new_field" class="block mb-2 text-sm font-medium text-gray-900 ">Name</label>
                  <input
                     type="text"
                     name="new_field"
                     id="new_field"
                     required
                     class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 "
                     value="{{ $report->name }}"
                     readonly
                     >                    
               </div>

               <div id="dateSelectError" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative hidden" role="alert">
                    <strong class="font-bold">Select other valid dates!</strong>
                    <span class="block sm:inline">Selected date is out of Report's Start and Target End date.</span>
               </div>

               <div>
                  <div class="flex justify-between space-x-4">
                     <div class="relative h-11 w-1/4 min-w-[200px]">
                           <label for="start-date-action" class="block text-sm font-medium text-gray-900 ">Start Date</label>
                              <input type="date" name="start-date-action" id="start-date-action" required
                                 class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 ">
                     </div>

                     <div class="relative h-11 w-1/4 min-w-[200px]">
                           <label for="target-date-action" class="block text-sm font-medium text-gray-900 ">Target End Date</label>
                              <input type="date" name="target-date-action" id="target-date-action" required
                                 class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 ">
                     </div>
                  </div>
               </div>

               <div class="mt-4">
                  <span class="block text-sm font-medium text-gray-900" id="daysCount"></span>
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
               <!--
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
                  </div>
               </div>
               <div>
                  <label for="remarks" class="block text-sm font-medium text-gray-900 ">Remarks</label>
                  <textarea name="remarks" id="remarks" rows="4"
                     class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 "
                     placeholder="Enter Remarks" required></textarea>
                  @error('remarks')
                     <p class="text-red-500 mt-1" role="alert">
                           <strong>{{ $message }}</strong>
                     </p>
                  @enderror
               </div>
               -->
               <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ">Submit</button>
            </form>
         </div>
      </div>
   </div>
</div>

@push('scripts')
<script>
$(document).ready(function () {
    var disabledDateRanges = [
    {
        startDate: '{{$report->startDate}}', 
        targetDate: '{{$report->targetDate}}',
        
    },
    @foreach ($report->submissions as $submission)
         {
               startDateAction: '{{$submission->startDate}}',
               targetDateAction: '{{$submission->targetDate}}',
         },
      @endforeach
   ];

    $('#start-date-action, #target-date-action').on('change', function () {
        var selectedDate = $(this).val();
        var disableDate = true;
        var dateSelectError = document.getElementById('dateSelectError');

        var startDateActionDiff = new Date($('#start-date-action').val());
        var targetDateActionDiff = new Date($('#target-date-action').val());

        if (startDateActionDiff !== null && targetDateActionDiff !== null) {
            var dateDifference = calculateDateDifference(startDateActionDiff, targetDateActionDiff);
            document.getElementById('daysCount').textContent = dateDifference + ' Working days.';
         } 

        disabledDateRanges.forEach(function (dateRange) {
            if (selectedDate >= dateRange.startDate && selectedDate <= dateRange.targetDate) {
                disableDate = false;
            }
        });

        disabledDateRanges.forEach(function (dateRange) {
            if (selectedDate >= dateRange.startDateAction && selectedDate <= dateRange.targetDateAction) {
               disableDate = true;
            }
        });
        

        if (disableDate) {
         dateSelectError.style.display = 'block';
         $(this).val('');
        } else {
         dateSelectError.style.display = 'none';
        }
    });

    function calculateDateDifference(startDate, endDate) {
      // Calculate the date difference in days
      const oneDay = 24 * 60 * 60 * 1000; // hours * minutes * seconds * milliseconds
      const diffDays = Math.round(Math.abs((startDate - endDate) / oneDay));
      return diffDays;
   }
});
</script>
@endpush