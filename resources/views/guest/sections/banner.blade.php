@include('guest.navbar')

<div class="block w-full pt-20" id="bannerSection">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-14">
        <div class="text-center font-sans col-span-1">
            <div data-aos="zoom-in" data-aos-duration="1000" class="h-96 md:h-screen px-10 md:px-32 inline-block">
                <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 tracking-widest mt-44">EXPERIENCE</h1>
                <h1 class="text-2xl md:text-4xl font-extrabold text-gray-900 tracking-widest bg-transparent">THE<span class="text-yellow-600">DIFFERENCE</span></h1>
                <br>
                <div class="py-6 text-center md:text-left">
                    <a href="{{url('register')}}" class="text-md font-bold text-white px-4 py-2 rounded bg-yellow-400 mix-blend-luminosity">Be a Part of Us</a>
                </div>
            </div>

            <div class="h-96 mt-4 hidden md:block">
                <img data-aos="fade-up" data-aos-duration="1000" src="{{asset('assets/images/guest/product-banner.jpg')}}" class="h-screen w-full object-cover object-left" alt="">
            </div>

        </div>

        <div class="flex-col lg:col-span-1 md:col-span-2 sm:col-span-2">
            <div>
                <img data-aos="fade-up" class="w-full object-cover object-center" data-aos-duration="1000" src="{{asset('assets/images/guest/beauty-banner.jpg')}}" class="w-full object-scale-down" alt="">
            </div>

            <div data-aos="fade-left" data-aos-duration="500" class="px-10 py-6 tex-gray-900 w-full">
                <h1 class="text-center text-lg font-extrabold">MISSION</h1>

                <p class="p-6">
                To inspire people achieve their full potential for health and well-being. It is also our mission to provide the best opportunity in achieving your life and your health goals. 
                </p>
            </div>

            <div data-aos="fade-left" data-aos-duration="700" class="px-10 py-6 tex-gray-900 w-full">
                <h1 class="text-center text-lg font-extrabold">VISION</h1>

                <p class="p-6">
                To be the number one people-first oriented company with excellence in quality, service and access.
                </p>
            </div>
        </div>
    </div>
</div>
