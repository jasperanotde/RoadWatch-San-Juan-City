@extends('layout.layout')

@section('content')
<section class="bg-white mx-px md:mx-20 px-14 py-40">
  <div class="max-w-screen-lg text-gray-500 sm:text-lg">
        <h2 class="text-4xl font-extrabold leading-none tracking-tight font-josefinsans text-primary mb-10"><span class="underline underline-offset-3 decoration-7 decoration-secondary">About Us</span></h2>
        <p class="mb-4 font-light">Roadwatch San Juan City is a cutting-edge application developed by the Winit Group, dedicated to improving our community's road infrastructure. Our primary mission is to empower residents and commuters to report road damages swiftly and efficiently, fostering a safer and more accessible urban environment for all.</p>
        <p class="mb-4 font-medium">With a commitment to enhancing the quality of life in San Juan City, we at Roadwatch take pride in our dedication to transparency and accountability. We believe that by providing a platform for citizens to report road damages, we not only contribute to the immediate repair of hazards but also engage our community in the process of maintaining our city's roadways. As a collaborative effort between Winit Group and the people of San Juan City, Roadwatch represents the power of technology and community spirit coming together to create positive change. Join us in our mission to make our streets safer and our city more accessible.</p>
        <!--<a href="{{ route('reports.create') }}"><button class="mt-1 mx-2 md:mt-4 md:mx-3 px-4 py-1.5 md:px-9 md:py-2.5 bg-primary text-white text-xxs md:text-xs font-poppins font-normal rounded hover:bg-secondary hover:text-white focus:outline-none focus:bg-primary transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300">Make a Report +</button></a>-->
    </div>
</section>
@endsection