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
               <p class="text-sm text-gray-500">
                  <span class="text-primary">Start Action Date: </span>{{ \Carbon\Carbon::parse($submission->startDate)->format('F d, Y') }}<span class="text-primary"> | Target Action End Date: </span> {{ \Carbon\Carbon::parse($submission->targetDate)->format('F d, Y') }}
               </p>
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
            <!--<div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4">
               <p class="text-gray-600">
                   Attachments
               </p>
               <div class="space-y-2">
                   <div class="border-2 flex items-center p-2 rounded justify-between space-x-2">
                       <div class="space-x-2 truncate">
                           <svg xmlns="http://www.w3.org/2000/svg" class="fill-current inline text-gray-500" width="24" height="24" viewBox="0 0 24 24"><path d="M17 5v12c0 2.757-2.243 5-5 5s-5-2.243-5-5v-12c0-1.654 1.346-3 3-3s3 1.346 3 3v9c0 .551-.449 1-1 1s-1-.449-1-1v-8h-2v8c0 1.657 1.343 3 3 3s3-1.343 3-3v-9c0-2.761-2.239-5-5-5s-5 2.239-5 5v12c0 3.866 3.134 7 7 7s7-3.134 7-7v-12h-2z"/></svg>
                           <span>
                               resume_for_manager.pdf
                           </span>
                       </div>
                       <a href="#" class="text-purple-700 hover:underline">
                           Download
                       </a>
                   </div>
               
                   <div class="border-2 flex items-center p-2 rounded justify-between space-x-2">
                       <div class="space-x-2 truncate">
                           <svg xmlns="http://www.w3.org/2000/svg" class="fill-current inline text-gray-500" width="24" height="24" viewBox="0 0 24 24"><path d="M17 5v12c0 2.757-2.243 5-5 5s-5-2.243-5-5v-12c0-1.654 1.346-3 3-3s3 1.346 3 3v9c0 .551-.449 1-1 1s-1-.449-1-1v-8h-2v8c0 1.657 1.343 3 3 3s3-1.343 3-3v-9c0-2.761-2.239-5-5-5s-5 2.239-5 5v12c0 3.866 3.134 7 7 7s7-3.134 7-7v-12h-2z"/></svg>
                           <span>
                               resume_for_manager.pdf
                           </span>
                       </div>
                       <a href="#" class="text-purple-700 hover:underline">
                           Download
                       </a>
                   </div>
               </div>
               </div>-->
         </div>
         @if ($submission->is_updated != 1)
         <div class="flex items-center justify-end m-4">
            <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white ml-2 rounded-md" data-te-toggle="modal" data-te-target="#deleteModal{{ $submission->id }}" data-te-ripple-init data-te-ripple-color="light" type="button">Delete Action Slip</button>
         </div>
         @endif
      </div>
   </div>
</div>