<header>
        <nav class="absolute top-0 left-0 right-0 z-10 mx-5 sm:mx-20 bg-transparent border-gray-200">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="{{route('home')}}" class="flex items-center">
                    <img src="{{ asset('images/RoadWatch Logo.png') }}" class="h-8 mr-3" alt="RoadWatch Logo" />
                </a>
                <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-primary focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-default" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button>
                <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-normal flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-transparent">
                    <li>
                    <a href="{{ route('home') }}" class="block py-2 pl-3 pr-4 md:text-primary sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0" aria-current="page">Home</a>
                    </li>
                    <li>
                    <a href="{{ route('about') }}"  class="block py-2 pl-3 pr-4 md:text-primary sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0">About</a>
                    </li>
                    <li>
                    <a href="{{ route('contact') }}"  class="block py-2 pl-3 pr-4 md:text-primary sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0">Contact</a>
                    </li>
                    <li>
                    <a href="{{ route('reports.index') }}"  class="block py-2 pl-3 pr-4 md:text-primary sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0">Reports</a>
                    </li>
                    @guest
                        @if (Route::has('login'))
                            <li>
                                <a href="{{ route('login') }}" class="block py-2 pl-3 pr-4 md:text-primary sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0">{{ __('Login') }}</a>
                            </li>
                        @endif
                    
                        @if (Route::has('register'))
                            <li>
                                <a href="{{ route('register') }}" class="block py-2 pl-3 pr-4 md:text-primary sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0">{{ __('Register') }}</a>
                            </li>
                        @endif
                        @else
                            <div class="relative mb-2" data-te-dropdown-ref>
                                <button
                                    class="flex items-center whitespace-nowrap rounded bg-secondary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] motion-reduce:transition-none dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                                    type="button"
                                    id="dropdownMenuButton1d"
                                    data-te-dropdown-toggle-ref
                                    aria-expanded="false"
                                    data-te-ripple-init
                                    data-te-ripple-color="light">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M15.133 10.632v-1.8a5.407 5.407 0 0 0-4.154-5.262.955.955 0 0 0 .021-.106V1.1a1 1 0 0 0-2 0v2.364a.944.944 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C4.867 13.018 3 13.614 3 14.807 3 15.4 3 16 3.538 16h12.924C17 16 17 15.4 17 14.807c0-1.193-1.867-1.789-1.867-4.175Zm-13.267-.8a1 1 0 0 1-1-1 9.424 9.424 0 0 1 2.517-6.39A1.001 1.001 0 1 1 4.854 3.8a7.431 7.431 0 0 0-1.988 5.037 1 1 0 0 1-1 .995Zm16.268 0a1 1 0 0 1-1-1A7.431 7.431 0 0 0 15.146 3.8a1 1 0 0 1 1.471-1.354 9.425 9.425 0 0 1 2.517 6.391 1 1 0 0 1-1 .995ZM6.823 17a3.453 3.453 0 0 0 6.354 0H6.823Z"/>
                                        </svg>
                                        @if(auth()->check())
                                            <span class="text-white">{{ auth()->user()->unreadNotifications->count() }}</span>
                                        @endif
                                    </span>
                                </button>
                                <ul
                                    class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                                    aria-labelledby="dropdownMenuButton1d"
                                    data-te-dropdown-menu-ref>
                                    @if (auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                                        <li>
                                        <a
                                            class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                            href="{{ route('mark-as-read') }}"
                                            data-te-dropdown-item-ref
                                            >Mark All as Read</a>
                                        </li>
                                    @else
                                        <li>
                                        <a
                                            class="pointer-events-none block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                            href="#"
                                            data-te-dropdown-item-ref
                                            >No new Notification</a>
                                        </li>
                                    @endif

                                    @if (auth()->check())
                                        @foreach (auth()->user()->unreadNotifications as $notification)
                                            <a href="{{ $notification->data['notifURL'] ?? '#' }}" class="text-neutral-700"><li class="p-6 text-neutral-700 max-w-sm bg-slate-300"> {{ $notification->data['data'] }} </br> <span class = "text-sm">{{ $notification->data['date'] }}</span></li></a>
                                            <hr class="h-0 border border-t-0 border-solid border-neutral-700 opacity-25" />
                                        @endforeach
                                        @foreach (auth()->user()->readNotifications as $notification)
                                            <a href="{{ $notification->data['notifURL'] ?? '#' }}" class="text-neutral-800"><li class="p-6 text-neutral-800 max-w-sm bg-white"> {{ $notification->data['data'] }} </br> <span class = "text-sm">Viewed | {{ $notification->data['date'] }}</span></li></a>
                                            <hr class="h-0 border border-t-0 border-solid border-neutral-700 opacity-25" />
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <!-- -->
                            <div class="relative" data-te-dropdown-ref>
                                <button
                                    class="flex items-center whitespace-nowrap rounded bg-primary hover:bg-secondary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] motion-reduce:transition-none dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                                    type="button"
                                    id="dropdownMenuButton1d"
                                    data-te-dropdown-toggle-ref
                                    aria-expanded="false"
                                    data-te-ripple-init
                                    data-te-ripple-color="light">
                                    @foreach(Auth::user()->getRoleNames() as $roleName)
                                        {{ $roleName }}:
                                    @endforeach
                                    {{ Auth::user()->name }}
                                    <span class="ml-2 w-2">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            class="h-5 w-5">
                                            <path
                                            fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                </button>
                                <ul
                                    class="absolute float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                                    aria-labelledby="dropdownMenuButton1d"
                                    data-te-dropdown-menu-ref>
                                    <li>
                                        <a class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                            href="{{ route('reports.dashboard') }}"
                                            data-te-dropdown-item-ref>
                                            Dashboard </a>
                                    </li>
                                    @role('Admin')
                                    <li>
                                        <a class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                            href="{{ route('users.index') }}"
                                            data-te-dropdown-item-ref>
                                            Manage Users </a>
                                    </li>
                                    <li>
                                        <a
                                            class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                            href="{{ route('roles.index') }}"
                                            data-te-dropdown-item-ref>
                                            Manage Roles </a>
                                    </li>
                                    @endrole
                                    <hr class="my-2 h-0 border border-t-0 border-solid border-neutral-700 opacity-25 dark:border-neutral-200" />
                                    <li>
                                        <a class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                            href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();"
                                            data-te-dropdown-item-ref
                                            >{{ __('Logout') }} </a>
                                    </li>
                                </ul>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                     @endguest
                    </ul>
                    
                </div>
            </div>
        </nav>
    </header>