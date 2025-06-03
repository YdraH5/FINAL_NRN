
<nav x-data="{ open: false }" class="bg-transparent backdrop-blur-md sticky top-0 z-50 shadow-md w-full text-black">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <!-- Logo Left -->
      <div class="flex-shrink-0">
        <a href="{{ route('welcome') }}">
          <img src="{{ asset('images/NRN LOGO.png') }}" alt="NRN Logo"
            class="h-10 w-auto sm:h-12 transition duration-300 hover:scale-105">
        </a>
      </div>

      <!-- Navigation + Auth Right -->
      <div class="hidden sm:flex items-center space-x-6">
        <!-- Nav Links -->
        <x-nav-link href="#overview" class="text-base font-medium hover:text-blue-500 transition">Overview</x-nav-link>
        <x-nav-link href="#about-us" class="text-base font-medium hover:text-blue-500 transition">About Us</x-nav-link>
        <x-nav-link href="#nearby" class="text-base font-medium hover:text-blue-500 transition">Establishments</x-nav-link>
        <x-nav-link href="#rooms" class="text-base font-medium hover:text-blue-500 transition">Rooms</x-nav-link>

        <!-- Auth / User Dropdown -->
        @if(Auth::check())
          <x-dropdown>
            <x-slot name="trigger">
              <button class="flex items-center text-sm font-medium hover:text-blue-500 transition">
                @include('components.user-icon')
                <span class="ml-2">{{ Auth::user()->name }}</span>
                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
                </svg>
              </button>
            </x-slot>
            <x-slot name="content">
              <x-dropdown-link wire:navigate :href="route('profile.edit')">Profile</x-dropdown-link>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')"
                  onclick="event.preventDefault(); this.closest('form').submit();">Log out</x-dropdown-link>
              </form>
            </x-slot>
          </x-dropdown>
        @else
          <a href="{{ route('login') }}"
            class="flex items-center text-sm font-medium hover:text-blue-500 transition">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.5-1.632Z" />
            </svg>
            Log in
          </a>
        @endif
      </div>

      <!-- Mobile Hamburger Button -->
      <div class="sm:hidden flex items-center">
        <button @click="open = ! open"
          class="p-2 rounded-md text-gray-600 hover:text-blue-500 hover:bg-gray-100 transition">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex"
              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden"
              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile Nav -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden mt-4 space-y-2">
      <x-responsive-nav-link href="#overview">Overview</x-responsive-nav-link>
      <x-responsive-nav-link href="#about-us">About Us</x-responsive-nav-link>
      <x-responsive-nav-link href="#nearby">Establishments</x-responsive-nav-link>
      <x-responsive-nav-link href="#rooms">Rooms</x-responsive-nav-link>
      <x-responsive-nav-link href="#location">Location</x-responsive-nav-link>
      @if(Auth::check())
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <x-responsive-nav-link :href="route('logout')"
            onclick="event.preventDefault(); this.closest('form').submit();">Log out</x-responsive-nav-link>
        </form>
      @else
        <x-responsive-nav-link :href="route('login')">Log in</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('register')">Register</x-responsive-nav-link>
      @endif
    </div>
  </div>
</nav>


<script>
      // Function to check current URL and highlight the active link
      function highlightActiveLink() {
        // Get the current URL hash (e.g., #overview, #about_us)
        const currentHash = window.location.hash;

        // Remove 'active' class from all nav links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
        });

        // Add 'active' class to the link that matches the current hash
        if (currentHash) {
            const activeLink = document.querySelector(`a[href="{{ route('welcome') }}${currentHash}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
            }
        }
    }

    // Initial highlighting when the page loads
    highlightActiveLink();

    // Re-run the function whenever the URL hash changes
    window.addEventListener('hashchange', highlightActiveLink);

</script>