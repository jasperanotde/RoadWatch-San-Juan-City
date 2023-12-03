<div data-te-modal-init class="bg-black bg-opacity-50 fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" data-te-modal-init id="editPersonnelModal{{ $cityEngineer->id }}"  tabindex="-1" aria-hidden="true" role="dialog">
    <div data-te-modal-dialog-ref class="relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
        <!-- Modal content -->
        <div class="relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <!-- Modal header/Title -->
            <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200" id="exampleModalCenterTitle">
                Add/Remove Personnel
                </h5>
                <!--Close button-->
                <button type="button" class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none" data-te-modal-dismiss aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {!! Form::model($cityEngineer, ['method' => 'PATCH','route' => ['personnels.update', $cityEngineer->id, 'enctype' => 'multipart/form-data']]) !!}
            @csrf
            <div class="relative flex-auto p-4">
                <div>
                    <label for="personnel" class="block text-sm font-medium text-gray-900 ">Personnel</label>
                    <div id="personnel-container-{{ $cityEngineer->id }}">
                        @if($personnel[$cityEngineer->id] !== null && count($personnel[$cityEngineer->id]) > 0)
                            @foreach($personnel[$cityEngineer->id] as $person)
                                <div id="personnel-input-{{ $cityEngineer->id }}">
                                    <div class="relative mb-2">
                                        <input
                                            type="text"
                                            name="personnel[]"
                                            class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400"
                                            placeholder="Enter Personnel"
                                            value="{{ old('name', $person->name) }}"
                                            required
                                            readonly
                                        >
                                        <div class="absolute top-1 right-1">
                                            <button class="delete-personnel p-1 h-8 w-7 text-white rounded-lg bg-red-500 hover:bg-red-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex w-5 h-5 items-center justify-center" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @else 
                        <p>No personnel records found.</p>
                        @endif
                        <button type="button" id="add-personnel-{{ $cityEngineer->id }}" class="text-blue-500 hover:underline focus:outline-none">
                            Add Personnel
                        </button>
                </div>
                <div class="flex flex-shrink-0 flex-wrap items-center justify-center rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50" data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="evenodd" stroke-linejoin="round" d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                            <path stroke-linecap="evenodd" stroke-linejoin="round" d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                        </svg>
                            Save
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const addPersonnelButton = document.getElementById("add-personnel-{{ $cityEngineer->id }}");
        const personnelContainer = document.getElementById("personnel-container-{{ $cityEngineer->id }}");

        addPersonnelButton.addEventListener("click", function () {
            const personnelInput = document.createElement("div");
            personnelInput.innerHTML = `
            <div class="relative mb-2 personnel-input">
                <input
                    type="text"
                    name="personnel[]"
                    class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400"
                    placeholder="Enter Personnel"
                    required
                >
                <div class="absolute top-1 right-1">
                    <button type="button" class="delete-personnel p-1 h-8 w-7 text-white rounded-lg bg-red-500 hover:bg-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex w-5 h-5 items-center justify-center" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"/>
                        </svg>
                    </button>
                </div>
            </div>
            `;

            const deleteButton = personnelInput.querySelector(".delete-personnel");
            deleteButton.addEventListener("click", function () {
                personnelContainer.removeChild(personnelInput);
            });

            personnelContainer.appendChild(personnelInput);
        });

        // Get all delete buttons inside the form
        const deleteButtonsInForm = document.querySelectorAll('.delete-personnel');

        // Add event listener to each delete button
        deleteButtonsInForm.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default form submission

                const personnelInput = document.getElementById("personnel-input-{{ $cityEngineer->id }}");
                personnelInput.remove(); // Remove the personnel input field when delete is clicked
            });
        });
    });
</script>
@endpush


