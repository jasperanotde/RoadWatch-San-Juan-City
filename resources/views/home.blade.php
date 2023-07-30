<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>
    <header class="relative">
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
                    <a href="#" class="block py-2 pl-3 pr-4 md:text-white sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0" aria-current="page">Home</a>
                    </li>
                    <li>
                    <a href="#" class="block py-2 pl-3 pr-4 md:text-white sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0">About</a>
                    </li>
                    <li>
                    <a href="#" class="block py-2 pl-3 pr-4 md:text-white sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0">Contact</a>
                    </li>
                    <li>
                    <a href="#" class="block py-2 pl-3 pr-4 md:text-white sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0">Reports</a>
                    </li>
                    <li>
                    <a href="#" class="block py-2 pl-3 pr-4 md:text-white sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0">Login</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>

        <div class="w-full h-screen bg-center bg-cover" style="height:32rem; background-image:linear-gradient(180deg, rgba(0, 63, 103, 0) 0%, #113F67 100%), url('images/San Juan Aerial.png');">
            <div class="flex items-center justify-center h-full w-full">
                <div class="text-center">
                    <h1 class="font-josefinsans font-bold uppercase text-white text-2xl sm:text-4xl md:text-5xl lg:text-6xl">ENSURING SAFE JOURNEYS</br>ONE MILE AT A TIME!</h1>
                    <hr class="w-9/12 md:w-10/12 lg:w-11/12 h-1 md:h-1.5 mx-auto bg-white border-0 rounded my-2 sm:my-4 md:my-4 ">
                    <div class="">
                        <p class="font-poppins font-normal text-secondary text-xxs sm:text-xs md:text-sm lg:text-2xl">RoadWatch San Juan City: Empowering citizens to report and</br>repair damaged roads for safer and smoother journeys.</p>
                        <button class="mt-1 mx-2 md:mt-4 md:mx-3 px-4 py-1.5 md:px-9 md:py-2.5 bg-white text-primary text-xxs md:text-xs font-poppins font-normal rounded hover:bg-secondary hover:text-white focus:outline-none focus:bg-primary transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300">View Reports</button>
                        <button class="mt-1 mx-2 md:mt-4 md:mx-3 px-4 py-1.5 md:px-9 md:py-2.5 bg-white text-primary text-xxs md:text-xs font-poppins font-normal rounded hover:bg-secondary hover:text-white focus:outline-none focus:bg-primary transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300">Make a Report +</button>
                    </div>    
                </div>
            </div>
        </div>
    </header>
    
    <section class="bg-white mx-5 sm:mx-20">
        <div class="mt-10 grid justify-items-center">
            <h1 class="text-4xl font-extrabold leading-none tracking-tight font-josefinsans text-primary"><span class="underline underline-offset-3 decoration-7 decoration-secondary">News & Updates</span></h1>
        </div>
        <div class="gap-8 items-center py-8 px-4 xl:gap-16 md:grid md:grid-cols-2 sm:py-14 lg:px-6">
            <img class="rounded-xl drop-shadow-xl" src="images/San Juan City Hall.jpg" alt="San Juan City Hall">
            <div class="mt-4 md:mt-0">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold font-josefinsans text-primary">Lorem ipsum dolor sit amet, consectetur.</h2>
                <p class="mb-6 font-light text-gray-500 md:text-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
    </section>

    <hr class="w-80 h-1 mx-auto bg-primary border-0 rounded">

    <section class="bg-white mx-5 sm:mx-20">
        <div class="gap-8 items-center py-8 px-4 xl:gap-16 md:grid md:grid-cols-2 sm:py-14 lg:px-6">
            <div class="mt-4 md:mt-0">
                <p class="mb-6 font-light text-gray-500 md:text-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <img class="rounded-xl drop-shadow-xl" src="images/San Juan Road.jpg" alt="San Juan City Road">
        </div>
    </section>

    <section class="bg-white mx-5 sm:mx-40">
        <div class="grid justify-items-center">
            <h1 class="text-4xl font-extrabold leading-none tracking-tight font-josefinsans text-primary"><span class="underline underline-offset-3 decoration-7 decoration-secondary">Completed Reports</span></h1>
        </div>
        <div class="py-8 px-4 md:gap-12 md:grid md:grid-cols-2 sm:pt-14 sm:pb-2 lg:px-6">
            <img class="rounded-xl mb-2 lg:mb-0" src="images/San Juan City Hall.jpg" alt="San Juan City Hall">
            <img class="rounded-xl lg:mb-0" src="images/San Juan City Hall.jpg" alt="San Juan City Hall">
        </div>
        <h2 class="text-md tracking-tight font-extrabold font-josefinsans text-primary text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</h2>
        <p class="font-light text-gray-500 indent-10 md:text-md py-10">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </section>

    <footer class="bg-primary">
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
                        <img src="images/facebook.png" class="h-5" alt="Facebook Logo" />
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
</body>
</html>