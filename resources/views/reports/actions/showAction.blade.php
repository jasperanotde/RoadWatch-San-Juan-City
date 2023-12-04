<!-- New Record Slip Show Modal -->
<div data-te-modal-init class="bg-black bg-opacity-50 fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" data-te-modal-init id="showModal{{ $submission->id }}"  tabindex="-1" aria-hidden="true" role="dialog">
   <div data-te-modal-dialog-ref class="relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[768px]:mx-auto min-[768px]:mt-7 min-[768px]:min-h-[calc(100%-3.5rem)] max-w-[768px]">
      <!-- Modal content -->
      <div class="relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
         <div class="flex flex-shrink-0 items-center justify-between p-4 border-b">
            <div>
               <h2 class="text-2xl ">
                  Action Slip
               </h2>
            </div>
            <!--Close button-->
            <button type="button" class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none" data-te-modal-dismiss aria-label="Close">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
               </svg>
            </button>
         </div>
         <div class="m-5">
            <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
               <p class="text-gray-600">
                  Report Name
               </p>
               <p>
                  {{ $submission->new_field }}
               </p>
            </div>
            <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
               <p class="text-gray-600">
                  Location
               </p>
               <p>
                  {{ $submission->location }}
               </p>
            </div>
            <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
               <p class="text-gray-600">
                  Materials
               </p>
               @foreach (json_decode($submission->materials) as $key => $material)
               {{ $material }}
               @if ($key < count(json_decode($submission->materials)) - 1)
               , 
               @endif
               @endforeach
            </div>
            <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
               <p class="text-gray-600">
                  Personnel
               </p>
               @foreach (json_decode($submission->personnel) as $key => $person)
               {{ $person }}
               @if ($key < count(json_decode($submission->personnel)) - 1)
               , 
               @endif
               @endforeach
            </div>
            @if ($submission->is_updated == 1)
            <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
               <p class="text-gray-600">
                  Actions Taken
               </p>
               <ul>
                  @foreach ($submission->actionsTakenArray() as $action)
                  <li>
                     <input type="checkbox" disabled {{ in_array($action, $submission->actionsTakenArray()) ? 'checked' : '' }}>
                     {{ $action }}
                  </li>
                  @endforeach
               </ul>
            </div>
            <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
               <p class="text-gray-600">
                  Remarks
               </p>
               <p>
                  {{ $submission->remarks }}
               </p>
            </div>
            <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
               <p class="text-gray-600">
                  Updated Image
               </p>
               <div class="flex space-x-4"> <!-- Add a flex container and set spacing between children -->
                  @if (!is_null($submission->photo))
                        @foreach (json_decode($submission->photo) as $image)
                           <a href="{{ asset($image) }}" data-fancybox="gallery">
                              <img src="{{ asset($image) }}" width="100" height="100" class="rounded-lg border-solid border-2 border-primary img img-responsive" />
                           </a>
                        @endforeach
                  @else
                        {{ __('report.no_photo') }}
                  @endif
               </div>
            </div>
            @endif
            @foreach($submission->submissionsUpdate as $updates)
            <div class='border border-gray-300 rounded p-4'>
               <div class="flex justify-center items-center">
                  <p class="underline text-center text-green-600">
                     Updated at: {{ $updates->created_at->format('F j, Y') }}
                  </p>
               </div>
               <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                  <p class="text-gray-600">
                     Actions Taken
                  </p>
                  <ul>
                     @foreach ($updates->actionsTakenArray() as $action)
                     <li>
                        <input type="checkbox" disabled {{ in_array($action, $updates->actionsTakenArray()) ? 'checked' : '' }}>
                        {{ $action }}
                     </li>
                     @endforeach
                  </ul>
               </div>
               <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                  <p class="text-gray-600">
                     Remarks
                  </p>
                  <p>
                     {{ $updates->remarks }}
                  </p>
               </div>
               <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                  <p class="text-gray-600">
                     Updated Image
                  </p>
                  <div class="flex space-x-4"> <!-- Add a flex container and set spacing between children -->
                     @if (!is_null($updates->photo))
                           @foreach (json_decode($updates->photo) as $image)
                              <a href="{{ asset($image) }}" data-fancybox="gallery">
                                 <img src="{{ asset($image) }}" width="100" height="100" class="rounded-lg border-solid border-2 border-primary img img-responsive" />
                              </a>
                           @endforeach
                     @else
                           {{ __('report.no_photo') }}
                     @endif
                  </div>
               </div>
            </div>
            @endforeach      
            
         </div>
         @if ($submission->submissionsUpdate->count() === 0)
         <div class="flex items-center justify-end m-4">
            <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white ml-2 rounded-md" data-te-toggle="modal" data-te-target="#deleteModal{{ $submission->id }}" data-te-ripple-init data-te-ripple-color="light" type="button">Delete Action Slip</button>
         </div>
         @endif
      </div>
   </div>
</div>