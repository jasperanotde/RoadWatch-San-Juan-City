
<div data-te-modal-init class="bg-black bg-opacity-50 fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" data-te-modal-init id="showRoleModal{{ $role->id }}"  tabindex="-1" aria-hidden="true" role="dialog">
    <div data-te-modal-dialog-ref class="relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
        <!-- Modal content -->
        <div class="relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <!-- Modal header/Title -->
            <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200" id="exampleModalCenterTitle">
                Show Role
                </h5>
                <!--Close button-->
                <button type="button" class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none" data-te-modal-dismiss aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="relative flex-auto p-4">
                <div class="mb-3">
                    Permissions of role <strong>{{ $role->name }}</strong>
                </div>

                <div class="mx-10 mb-4">
                    @if (!is_null($show_rolePermissions) && count($show_rolePermissions) > 0)
                        @foreach ($show_rolePermissions[$role->id] as $permission)
                            <li>{{ $permission->name }}</li>
                        @endforeach
                    @else
                        <p>No permissions found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
