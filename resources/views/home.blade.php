@extends('layout.layout')

@section('content')

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
@endsection
