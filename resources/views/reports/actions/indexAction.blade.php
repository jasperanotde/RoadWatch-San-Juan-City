@if (auth()->check())
@role('Admin|City Engineer Supervisor|City Engineer')
<!------- Record Slip Index ------->
<div id="" class="flex justify-center m-5 sm:m-20 rounded-lg">
   <div class="w-full shadow-lg max-w-screen-xl">
      <div style="background: rgba(17,63,103); border-top-left-radius: 8px; border-top-right-radius: 8px; display: flex; justify-content: space-between; align-items: center;" class="text-white rounded-sm p-4">
         <h1 class="text-xl font-bold text-white">Action Slips</h1>
         <!-- Modal toggle -->
         <button class="float-right block mt-1 mx-2 md:mt-4 md:mx-3 px-4 py-1.5 md:px-9 md:py-2.5 bg-white text-primary text-xxs md:text-xs font-poppins font-normal rounded hover:bg-secondary hover:text-white focus:outline-none focus:bg-primary transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300" type="button" data-te-target="#authentication-modal" data-te-toggle="modal" data-te-ripple-init data-te-ripple-color="light">
            Create Action Slip <span styleg="font-size: 18px; font-weight: bold; margin-left: 5px;">+</span>
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
                        <button data-te-target="#showModal{{ $submission->id }}" data-te-toggle="modal" class="underline text-green-800" type="button" data-te-ripple-init data-te-ripple-color="light">{{ $submission->startDate }} to {{ $submission->targetDate }}</button>
                     </td>

                     <!-- Update Button -->
                     <td class="px-5 py-4 w-1/2 bg-red-100 hover:bg-gray-200">
                        @if ($submission->is_updated != 1)
                        <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md" type="button" data-te-target="#updateModal{{ $submission->id }}" data-te-toggle="modal" data-te-ripple-init data-te-ripple-color="light">
                           <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="evenodd" stroke-linejoin="round" d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                 <path stroke-linecap="evenodd" stroke-linejoin="round" d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                           </svg>
                           Update
                        </button>
                        @else
                        <p>Updated</p>
                        <p class="text-xs">{{ $submission->updated_at->format('Y-m-d') }}</p>
                        @endif
                        
                     </td>
                     <!-- Delete Button -->
                     @can('report-delete')
                     <td class="px-5 py-4 w-1/2 bg-red-100 hover:bg-gray-200">
                     @if ($submission->is_updated != 1)
                        <button class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md" data-te-toggle="modal" data-te-target="#deleteModal{{ $submission->id }}" data-te-ripple-init data-te-ripple-color="light" type="button">
                           <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                              <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"/>
                           </svg>
                           Delete
                        </button>
                     @endif
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
                     @include('reports.actions.showAction')
                     @include('reports.actions.updateAction')
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
   @else
   @if ($report->creator_id === auth()->user()->id)
   <!------- Record Slip Index ------->
   <div id="" class="flex justify-center m-20 rounded-lg">
      <div class="w-full shadow-lg max-w-screen-xl">
         <div style="background: rgba(17,63,103); border-top-left-radius: 8px; border-top-right-radius: 8px; display: flex; justify-content: space-between; align-items: center;" class="text-white rounded-sm p-4">
            <h1 class="text-xl font-bold text-white">Action Slips</h1>
            <!-- Modal toggle -->
            <!-- <button class="float-right block mt-1 mx-2 md:mt-4 md:mx-3 px-4 py-1.5 md:px-9 md:py-2.5 bg-white text-primary text-xxs md:text-xs font-poppins font-normal rounded hover:bg-secondary hover:text-white focus:outline-none focus:bg-primary transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300" type="button" data-te-target="#authentication-modal" data-te-toggle="modal" data-te-ripple-init data-te-ripple-color="light">
               Create Action Slip <span styleg="font-size: 18px; font-weight: bold; margin-left: 5px;">+</span>
               </span> -->
         </div>
         <div class="submission">
            <table class="w-full text-sm text-left text-gray-500">
               <thead class="text-md text-gray-700 uppercase bg-gray-50">
                  <tr>
                     <th scope="col" class="px-6 py-3">
                        Date
                     </th>
                     <!-- <th scope="col" class="px-6 py-3">
                        Action
                        </th> -->
                  </tr>
               </thead>
               <tbody>
                  @foreach ($report->submissions as $submission)
                  <tr class="bg-blue-100 border-b">
                     <!-- Show Button -->
                     <td class="px-5 py-4 w-full border-r">
                        <button data-te-target="#showModal{{ $submission->id }}" data-te-toggle="modal" class="underline text-green-800" type="button" data-te-ripple-init data-te-ripple-color="light">{{ $submission->startDate }} to {{ $submission->targetDate }}</button>
                     </td>
                     <!-- Delete Button -->
                     <!-- @can('report-delete')
                        <td class="px-5 py-4 w-1/2 bg-red-100 hover:bg-gray-200">
                           <button class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md" data-te-toggle="modal" data-te-target="#deleteModal{{ $submission->id }}" data-te-ripple-init data-te-ripple-color="light" type="button">
                              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"/>
                              </svg>
                              Delete
                           </button> -->
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
                     @include('reports.actions.showAction')
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
   @endif
   @endrole
   @endif
</div>

