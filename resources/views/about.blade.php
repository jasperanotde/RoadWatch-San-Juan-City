<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['resources/css/app.css','resources/js/app.js'])
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
                    <a href="#" class="block py-2 pl-3 pr-4 md:text-primary sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0">Contact</a>
                    </li>
                    <li>
                    <a href="#" class="block py-2 pl-3 pr-4 md:text-primary sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0">Reports</a>
                    </li>
                    <li>
                    <a href="#" class="block py-2 pl-3 pr-4 md:text-primary sm:text-primary rounded hover:bg-secondary md:hover:bg-transparent md:border-0 sm:hover:text-white md:hover:text-secondary transition ease-in-out delay-150 md:p-0">Login</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="bg-white mx-px md:mx-20 px-14 py-40">
        <div class="max-w-screen-lg text-gray-500 sm:text-lg">
            <h2 class="text-4xl font-extrabold leading-none tracking-tight font-josefinsans text-primary mb-10"><span class="underline underline-offset-3 decoration-7 decoration-secondary">About Us</span></h2>
            <p class="mb-4 font-light">Track work across the enterprise through an open, collaborative platform. Link issues across Jira and ingest data from other software development tools, so your IT support and operations teams have richer contextual information to rapidly respond to requests, incidents, and changes.</p>
            <p class="mb-4 font-medium">Deliver great service experiences fast - without the complexity of traditional ITSM solutions.Accelerate critical development work, eliminate toil, and deploy changes with ease.</p>
            <button class="mt-1 mx-2 md:mt-4 md:mx-3 px-4 py-1.5 md:px-9 md:py-2.5 bg-primary text-white text-xxs md:text-xs font-poppins font-normal rounded hover:bg-secondary hover:text-white focus:outline-none focus:bg-primary transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300">Make a Report +</button>
        </div>
    </section>

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