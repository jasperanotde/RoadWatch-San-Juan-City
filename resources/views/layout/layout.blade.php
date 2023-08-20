<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['resources/css/app.css','resources/js/app.js'])
  @yield('styles')
</head>

<body>
    <header>
        <nav class="absolute top-0 left-0 right-0 z-10 mx-5 sm:mx-20 bg-transparenr border-gray-200">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="" class="flex items-center">
                    <img src="images/RoadWatch Logo.png" class="h-8 mr-3" alt="RoadWatch Logo" />
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
                    <a href="#" class="block py-2 pl-3 pr-4 md:text-primary sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0" aria-current="page">Home</a>
                    </li>
                    <li>
                    <a href="#" class="block py-2 pl-3 pr-4 md:text-primary sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0">About</a>
                    </li>
                    <li>
                    <a href="#8" class="block py-2 pl-3 pr-4 md:text-primary sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0">Contact</a>
                    </li>
                    <li>
                    <a href="#" class="block py-2 pl-3 pr-4 md:text-primary sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0">Reports</a>
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
                                    {{ __('Admin') }} {{ Auth::user()->name }}
                                    <span class="ml-2 w-2"> <!-- {{ __('Admin') }} -- Still for configuration. Goal: Get the name ADMIN from DB -->
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
                                    class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                                    aria-labelledby="dropdownMenuButton1d"
                                    data-te-dropdown-menu-ref>
                                    <li>
                                        <a class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                            href="#"
                                            data-te-dropdown-item-ref>
                                            Profile </a>
                                    </li>
                                    <li>
                                        <a class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                            href="#"
                                            data-te-dropdown-item-ref>
                                            User Management </a>
                                    </li>
                                    <li>
                                        <a
                                            class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                            href="#"
                                            data-te-dropdown-item-ref>
                                            Setting </a>
                                    </li>
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

    @yield('content')

    <footer class="bg-primary my-auto">
        <div class="max-w-2xl mx-auto text-white py-10">
                <a href="" class="flex items-center">
                    <img src="images/RoadWatch Logo WB.png" class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4" alt="RoadWatch Logo" />
                </a>
            <div class="text-center my-8">
                <p> Lorem ipsum dolor sit amet, consectetur</br>adipiscing elit, sed do eiusmod tempor incididunt. </p>
                <div class="w-4/6 text-light text-sm flex justify-between mx-auto my-10">
                    <a href="" class="hover:text-secondary transition ease-in-out delay-150"> Privacy Policy </a>
                    <a href="" class="hover:text-secondary transition ease-in-out delay-150"> Terms and Condition </a>
                    <a href="" class="hover:text-secondary transition ease-in-out delay-150"> Copyrights </a>
                </div>
                <div class="w-36 flex flex-row space-x-8 justify-between mx-auto my-10">
                    <a href="">
                        <img src="{{url('images/facebook.png')}}" class="h-5" alt="Facebook Logo" />
                    </a>
                    <a href="">
                        <img src="images/twitter.png" class="h-5" alt="Facebook Logo" />
                    </a>
                    <a href="">
                        <img src="images/instagram.png" class="h-5" alt="Facebook Logo" />
                    </a>
                </div>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>