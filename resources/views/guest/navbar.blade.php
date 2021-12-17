<!-- This example requires Tailwind CSS v2.0+ -->
<nav class="fixed top-0 left-0 w-full z-50 bg-white shadow-lg">
  <div class="max-w-7xl mx-auto px-2 py-2 sm:px-6 lg:px-14">
    <div class="relative flex items-center justify-between h-16">
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <!-- Mobile menu button-->
        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-800 hover:text-white hover:bg-yellow-300 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white toggle-menu" data-toggle="#mobile-menu" aria-controls="mobile-menu" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <!--
            Icon when menu is closed.

            Heroicon name: outline/menu

            Menu open: "hidden", Menu closed: "block"
          -->
          <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <!--
            Icon when menu is open.

            Heroicon name: outline/x

            Menu open: "block", Menu closed: "hidden"
          -->
          <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="flex-1 flex items-center justify-evenly sm:items-stretch sm:justify-evenly">
        <div class="w-5/12 hidden sm:block sm:ml-6">
          <div class="flex space-x-4">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-900 hover:bg-yellow-300 hover:text-white" -->
            <a href="#productSection" class="nav--link text-gray-900 hover:bg-yellow-300 hover:text-white px-3 py-2 rounded-md text-sm font-bold" aria-current="page">Products</a>

            <a href="#aboutSection" class="nav--link text-gray-900 hover:bg-yellow-300 hover:text-white px-3 py-2 rounded-md text-sm font-bold">About Us</a>

            <a href="#testimonialSection" class="nav--link text-gray-900 hover:bg-yellow-300 hover:text-white px-3 py-2 rounded-md text-sm font-bold">Testimonial</a>

          </div>
        </div>

        <div class="flex-shrink-0 flex items-center">
          <a href="#bannerSection" class="nav--link">
            <img class="block lg:hidden h-10 w-auto" src="{{asset('assets/images/iwellness_logo.png')}}" alt="Workflow">
            <img class="hidden lg:block h-10 w-auto" src="{{asset('assets/images/iwellness_logo.png')}}" alt="Workflow">
          </a>
        </div>

        <div class="w-5/12 hidden sm:block sm:ml-6">
          <div class="flex justify-end space-x-4">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-900 hover:bg-yellow-300 hover:text-white" -->
           
            <a href="javascript:void(0)" id="cartNav" data-modal="true" class="text-gray-900 hover:bg-yellow-300 hover:text-white px-3 py-2 rounded-md text-sm font-bold toggle-menu" data-toggle="#viewCart">
              <div id="cartNavCont">
                <i class="fa-shopping-bag" aria-hidden="true"></i>
                <span class="text-xs bg-yellow-300 text-white font-bold px-2 py-1 leading-none rounded-full transform -translate-y-20">{{collect(auth()->user()->cart ?? json_decode(Session::get('my-cart')))->count()}}</span>
              </div>
            </a>

            <a href="{{url('login')}}" class="bg-yellow-300 text-white hover:text-white px-3 py-2 rounded-md text-sm font-bold">Sign In</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile menu, show/hide based on menu state. -->
  <div class="lg:hidden sm:hidden hidden" id="mobile-menu">
    <div class="px-2 pt-2 pb-3 space-y-1">
      <!-- Current: "bg-gray-900 text-white", Default: "text-gray-900 hover:bg-yellow-300 hover:text-white" -->
      <a href="#productSection" class="nav--link text-gray-900 hover:bg-gray-100 block px-3 py-2 rounded text-base font-medium" aria-current="page">Products</a>

      <a href="#aboutSection" class="text-gray-900 hover:bg-gray-100 block px-3 py-2 rounded text-base font-medium">About Us</a>

      <a href="#testimonialSection" class="text-gray-900 hover:bg-gray-100 block px-3 py-2 rounded text-base font-medium">Testimonial</a>

      <a href="javascript:void(0)" class="text-gray-900 hover:bg-gray-100 block px-3 py-2 rounded text-base font-medium toggle-menu" data-toggle="#viewCart">Cart</a>

      <a href="{{url('login')}}" class="bg-yellow-300 text-white block px-3 py-2 rounded text-base font-medium">Sign In</a>
    </div>
  </div>
</nav>
