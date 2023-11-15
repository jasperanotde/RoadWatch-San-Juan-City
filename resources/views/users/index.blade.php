@extends('layout.layout')

@section('content')

<div class="max-w-5xl mx-auto my-20">
@if ($message = Session::get('success'))
    <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-medium">{{ $message }}</span>
        </div>
    </div>
@endif

@if (count($errors) > 0)
    <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-medium">Error. There were some problems with your input.
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </span>
        </div>
    </div>
@endif

    <div class="my-10 flex flex-col items-center lg:flex-row lg:items-center">
        <h1 class="font-josefinsans font-bold text-2xl sm:text-4xl font-normal leading-none tracking-tight font-poppins text-primary"><span class="font-josefinsans font-bold underline underline-offset-3 decoration-7 decoration-secondary">{{ __('app.user_title') }}</span></h1>
    </div>

    <div class="mb-20 relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="p-4">
            <label for="datatable-search-input" class="sr-only">Search</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="search" id="datatable-search-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
            </div>
        </div>
        <div id="datatable">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            User Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $user)
                    @if(!$user->getRoleNames()->contains('Admin'))
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4">
                            {{ ++$i }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4">
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                @endforeach
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col lg:flex-row items-center justify-center">
                            <button class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-md" type="button" data-te-target="#showUserModal{{ $user->id }}" data-te-toggle="modal" data-te-ripple-init data-te-ripple-color="light">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 lg:w-6 lg:h-6">
                                        <path fill-rule="evenodd" d="M15.75 2.25H21a.75.75 0 01.75.75v5.25a.75.75 0 01-1.5 0V4.81L8.03 17.03a.75.75 0 01-1.06-1.06L19.19 3.75h-3.44a.75.75 0 010-1.5zm-10.5 4.5a1.5 1.5 0 00-1.5 1.5v10.5a1.5 1.5 0 001.5 1.5h10.5a1.5 1.5 0 001.5-1.5V10.5a.75.75 0 011.5 0v8.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V8.25a3 3 0 013-3h8.25a.75.75 0 010 1.5H5.25z" clip-rule="evenodd" />
                                    </svg>
                                    Show
                                </button>
                                @can('user-edit')
                                <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md" type="button" data-te-target="#editUserModal{{ $user->id }}" data-te-toggle="modal" data-te-ripple-init data-te-ripple-color="light">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="evenodd" stroke-linejoin="round" d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                        <path stroke-linecap="evenodd" stroke-linejoin="round" d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                                    </svg>
                                    Edit
                                </button>
                                @endcan

                                @can('user-delete')
                                <button class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md" type="button" data-te-target="#deleteUserModal{{ $user->id }}" data-te-toggle="modal" data-te-ripple-init data-te-ripple-color="light">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"/>
                                    </svg>
                                    Delete
                                </button>
                                <!-- Delete Modal -->
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" enctype="muiltipart/form-data">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                                    <div data-te-modal-init class="bg-black bg-opacity-50 fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-modal="true" role="dialog">
                                        <div data-te-modal-dialog-ref class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
                                            <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                                                <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                                                    <!--Modal title-->
                                                    <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200">
                                                    Delete Role
                                                    </h5>
                                                </div>
                                                <!--Modal body-->
                                                <div class="relative p-4">
                                                    <p>Are you sure you want to delete user<b> {{ $user->name }}</b>?</p>
                                                </div>
                                                <!--Modal footer-->
                                                <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                                                    <button type="button" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-md" data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white ml-2 rounded-md" data-te-ripple-init data-te-ripple-color="light">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @endcan
                            </div>
                            @include('users.show')
                            @include('users.edit')
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
                <div class="card-body">{!! $data->render() !!}</div>
        </div>
        <script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>
    </div>
</div>
@endsection