<!-- Update Action Slip Modal -->
<div data-te-modal-init class="bg-black bg-opacity-50 fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" data-te-modal-init id="updateModal"  tabindex="-1" aria-hidden="true" role="dialog">
   <div data-te-modal-dialog-ref class="relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[768px]:mx-auto min-[768px]:mt-7 min-[768px]:min-h-[calc(100%-3.5rem)] max-w-[768px]">
      <!-- Modal content -->
      <div class="relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
         <div class="flex flex-shrink-0 items-center justify-between p-4 border-b">
            <div>
               <h2 class="text-2xl ">
                  Action Slip
               </h2>
               <p class="text-sm text-gray-500">
                  <span class="text-primary">Start Action Date: </span>{{ \Carbon\Carbon::parse($submission->startDate)->format('F d, Y') }} <span class="text-primary">| Target Action End Date: </span> {{ \Carbon\Carbon::parse($submission->targetDate)->format('F d, Y') }}
               </p>
            </div>
            <!--Close button-->
            <button type="button" class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none" data-te-modal-dismiss aria-label="Close">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
               </svg>
            </button>
         </div>
         <div class="relative overflow-y-auto px-6 py-6 lg:px-8">
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
            
               <Form action="{{ route('reports.submissions.create', ['report' => $report, 'submission' => $submission]) }}"  method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="p-4">
                     <label class="flex mb-5 text-sm font-medium text-gray-900">Actions Taken</label>
                     <div class=" grid grid-cols-2 gap-2 content-center">
                        <label class="inline-flex items-center">
                        <input type="checkbox" name="actions_taken[]" value="Declogged"
                           class="form-checkbox h-5 w-5 text-blue-600"
                           @if (!empty($submission->submissionsUpdate()->actions_taken))
                              @php
                                 $actionsTakenArray = json_decode($submission->submissionsUpdate()->actions_taken, true);
                              @endphp

                              @if (is_array($actionsTakenArray) && in_array('Declogged', $actionsTakenArray))
                                 checked
                              @endif
                           @endif>
                           <span class="ml-2 text-gray-900">Declogged</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="checkbox" name="actions_taken[]" value="Repaired"
                           class="form-checkbox h-5 w-5 text-blue-600"
                           @if (!empty($submission->submissionsUpdate()->actions_taken))
                              @php
                                 $actionsTakenArray = json_decode($submission->submissionsUpdate()->actions_taken, true);
                              @endphp

                              @if (is_array($actionsTakenArray) && in_array('Repaired', $actionsTakenArray))
                                 checked
                              @endif
                           @endif>
                           <span class="ml-2 text-gray-900 ">Repaired</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="checkbox" name="actions_taken[]" value="Inspected"
                           class="form-checkbox h-5 w-5 text-blue-600"
                           @if (!empty($submission->submissionsUpdate()->actions_taken))
                              @php
                                 $actionsTakenArray = json_decode($submission->submissionsUpdate()->actions_taken, true);
                              @endphp

                              @if (is_array($actionsTakenArray) && in_array('Inspected', $actionsTakenArray))
                                 checked
                              @endif
                           @endif>
                           <span class="ml-2 text-gray-900 ">Inspected</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="checkbox" name="actions_taken[]" value="Painted"
                           class="form-checkbox h-5 w-5 text-blue-600"
                           @if (!empty($submission->submissionsUpdate()->actions_taken))
                              @php
                                 $actionsTakenArray = json_decode($submission->submissionsUpdate()->actions_taken, true);
                              @endphp

                              @if (is_array($actionsTakenArray) && in_array('Painted', $actionsTakenArray))
                                 checked
                              @endif
                           @endif>
                           <span class="ml-2 text-gray-900 ">Painted</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="checkbox" name="actions_taken[]" value="Tree Trimmed/Cut"
                           class="form-checkbox h-5 w-5 text-blue-600"
                           @if (!empty($submission->submissionsUpdate()->actions_taken))
                              @php
                                 $actionsTakenArray = json_decode($submission->submissionsUpdate()->actions_taken, true);
                              @endphp

                              @if (is_array($actionsTakenArray) && in_array('Tree Trimmed/Cut', $actionsTakenArray))
                                 checked
                              @endif
                           @endif>
                           <span class="ml-2 text-gray-900 ">Tree Trimmed/Cut</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="checkbox" name="actions_taken[]" value="Trouble Shoot"
                           class="form-checkbox h-5 w-5 text-blue-600"
                           @if (!empty($submission->submissionsUpdate()->actions_taken))
                              @php
                                 $actionsTakenArray = json_decode($submission->submissionsUpdate()->actions_taken, true);
                              @endphp

                              @if (is_array($actionsTakenArray) && in_array('Trouble Shoot', $actionsTakenArray))
                                 checked
                              @endif
                           @endif>
                           <span class="ml-2 text-gray-900 ">Trouble Shoot</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="checkbox" name="actions_taken[]" value="Installed"
                           class="form-checkbox h-5 w-5 text-blue-600"
                           @if (!empty($submission->submissionsUpdate()->actions_taken))
                              @php
                                 $actionsTakenArray = json_decode($submission->submissionsUpdate()->actions_taken, true);
                              @endphp

                              @if (is_array($actionsTakenArray) && in_array('Installed', $actionsTakenArray))
                                 checked
                              @endif
                           @endif>
                           <span class="ml-2 text-gray-900 ">Installed</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="checkbox" name="actions_taken[]" value="Others"
                           class="form-checkbox h-5 w-5 text-blue-600"
                           @if (!empty($submission->submissionsUpdate()->actions_taken))
                              @php
                                 $actionsTakenArray = json_decode($submission->submissionsUpdate()->actions_taken, true);
                              @endphp

                              @if (is_array($actionsTakenArray) && in_array('Others', $actionsTakenArray))
                                 checked
                              @endif
                           @endif>
                           <span class="ml-2 text-gray-900 ">Others</span>
                        </label>
                        <!-- Add more checkboxes as needed -->
                     </div>
                  </div>
               
                  <div class="p-2 w-full">
                     <div class="relative">
                        <label for="photo" class="leading-7 text-sm text-gray-600">Select photo of the current progress</label>
                        <input
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            name="photo[]"
                            type="file"
                            id="photoAction"
                            multiple
                            required>
                            <div class="px-4 py-4 bg-gray-100 hover:bg-gray-200" id="selectedImagesContainerAction" hidden>
                                <div class="block text-sm font-medium text-gray-600">
                                    Updated Images of the Report to mark as Done
                                    <div class="flex items-center place-content-center">
                                        <div id="photoPreviewsAction"></div>
                                    </div>
                                </div>
                            </div>
                            {!! $errors->first('photo', '<span class="text-red-500 text-sm">:message</span>') !!}
                     </div>
                  </div>

                  <div class="p-2 w-full">
                     <label for="remarks" class="block text-sm font-medium text-gray-900 ">Remarks</label>
                     <textarea name="remarks" id="remarks" rows="4"
                        class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 "
                        placeholder="Enter Remarks"
                        required>{{ $submission->remarks }}</textarea>
                     @error('remarks')
                        <p class="text-red-500 mt-1" role="alert">
                              <strong>{{ $message }}</strong>
                        </p>
                     @enderror
                  </div>
                  <div class="flex items-center justify-end m-4">
                     <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md" data-te-toggle="modal" data-te-target="#confirmUpdateModal" data-te-ripple-init data-te-ripple-color="light" type="button">Update</button>
                  </div>
                  <div data-te-modal-init class="bg-black bg-opacity-50 fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" id="confirmUpdateModal" tabindex="-1" aria-modal="true" role="dialog">
                     <div data-te-modal-dialog-ref class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
                        <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                           <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                              <!--Modal title-->
                              <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200">
                                 Update Action Slip
                              </h5>
                           </div>
                           <!--Modal body-->
                           <div class="relative p-4">
                              <p>There is no reverting process when this action slip is updated. Are you sure you want to continue?</p>
                           </div>
                           <!--Modal footer-->
                           <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                              <button type="button" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-md" data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                              Cancel
                              </button>
                              <!-- <input type="hidden" name="submission_id" value="{{ $submission->id }}"> -->
                              <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md" data-te-ripple-init data-te-ripple-color="light">
                              Update
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
// Image Handler   
// Get references to the input field and image previews container
var imageInput = document.getElementById('photoAction');
var imagePreviews = document.getElementById('photoPreviewsAction');
var selectedImagesContainer = document.getElementById('selectedImagesContainerAction');

// Create an array to store Fancybox gallery items
var galleryItems = [];

// Add an event listener to the input field
imageInput.addEventListener('change', function () {
  // Clear any existing image previews
  imagePreviews.innerHTML = '';
  imagePreviews.classList.add('flex', 'items-center', 'place-justify-center');

  // Create a Fancybox gallery
  var galleryId = 'gallery-' + Math.random(); // Generate a unique gallery ID

  // Check if files are selected
  if (imageInput.files.length > 0) {
    selectedImagesContainer.removeAttribute('hidden'); // Show the container
  } else {
    selectedImagesContainer.setAttribute('hidden', 'true'); // Hide the container
  }

  // Loop through selected files
  for (var i = 0; i < imageInput.files.length; i++) {
    (function (file, i) { // Use an IIFE to capture the current file
      if (file) {
        var reader = new FileReader();

        // Create a "Delete" button
        var deleteButton = document.createElement('button');
        deleteButton.innerText = 'Delete';
        deleteButton.classList.add('bg-red-500', 'text-white', 'p-2', 'mt-1');

        // Create a new image element for the preview
        var previewImage = document.createElement('a'); // Wrap the image in an anchor
        previewImage.classList.add('mr-4');
        var image = document.createElement('img');
        image.style.maxWidth = '100px'; // Set maximum width for the preview
        image.style.maxHeight = '100px'; // Set maximum height for the preview
        image.classList.add('rounded-lg', 'border-solid', 'border-2', 'border-primary');
        
        // Set up the reader to load when the file is loaded
        reader.onload = function (e) {
          // Display the image preview
          image.src = e.target.result;

          // Add the image to the Fancybox gallery
          var galleryItem = {
            src: e.target.result,
            opts: {
              caption: 'Image ' + (i + 1) // Add a caption for each image
            }
          };
          galleryItems[i] = galleryItem;

          // Set Fancybox attributes
          previewImage.href = e.target.result; // Set the href attribute for the anchor
          previewImage.setAttribute('data-fancybox', galleryId); // Set Fancybox attribute

          previewImage.appendChild(image); // Append the image to the anchor
          previewImage.appendChild(deleteButton); // Append the "Delete" button
          imagePreviews.appendChild(previewImage); // Append the anchor to the container
        };

        // Read the current file as a data URL
        reader.readAsDataURL(file);

        // Add a click event listener to the "Delete" button
        deleteButton.addEventListener('click', function () {
          // Remove the image preview
          imagePreviews.removeChild(previewImage);

          // Remove the file from the input's files array
          var newFiles = Array.from(imageInput.files);
          newFiles.splice(i, 1);
          imageInput.files = newFiles;

          // Update the Fancybox gallery items
          galleryItems.splice(i, 1);
        });
      }
    })(imageInput.files[i], i);
  }

  // Initialize Fancybox for the gallery
  $('[data-fancybox="' + galleryId + '"]').fancybox({
    loop: true, // Enable looping through images
    // Add any additional Fancybox options here
  });
});
});
</script>
@endpush
