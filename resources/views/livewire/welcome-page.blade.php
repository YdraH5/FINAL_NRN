<div id="overview">
    <div class="bg-gray-900 text-white overflow-hidden">
        <!-- Hero Section -->
        <div class=" max-h-[calc(100vh-4rem)] w-full h-screen flex items-center">
            <!-- Background Image -->
           <div class="absolute inset-0 z-0">
                <img src="images/NRNBUILDING2.png" alt="NRN Building" 
                    class="w-full h-full object-cover object-center"
                    loading="eager">
                <!-- Gradient overlay: dark gray to transparent -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/60  via-gray-800/30 to-transparent"></div>
            </div>



            <!-- Content Container - Left Aligned -->
            <div class="relative z-10 px-8 md:px-16 lg:px-24 max-w-5xl mx-0">
                <div class="space-y-6 text-left">
                    
                    <!-- Main Headline -->
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-san-serif font-medium leading-tight tracking-tight">
                        <span class="block text-gray-50">Your Comfort,</span>
                        <span class="block text-blue-300/90 italic font-light">Our Commitment</span>
                    </h1>
                    
                    <!-- Subheading -->
                    <p class="text-lg md:text-xl opacity-90 mt-6 leading-relaxed">
                        Modern apartments designed for your lifestyle in the heart of Roxas City. Experience the perfect blend of comfort and convenience.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-8">
                        <a href="#rooms" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-300 text-center">
                            View Apartments
                        </a>
                        <a href="#contact" class="px-8 py-3 border border-white hover:bg-white/10 text-white font-semibold rounded-lg transition-colors duration-300 text-center">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>

            <!-- Scroll Indicator (Center aligned) -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10">
                <a href="#about-us" class="flex flex-col items-center">
                    <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
        <div id="about-us" class="bg-white py-8 md:py-8 px-4 md:px-8 lg:px-16">
            <div class="max-w-full mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="font-san-serif text-3xl md:text-4xl lg:text-5xl text-gray-900 mb-6 leading-tight">
                        About Us
                    </h2>
                    @isset($settings->discover_description)
                    <p class="text-lg text-gray-800 max-w-6xl mx-auto mt-4">
                        {{ $settings->discover_description }}
                    </p>
                    @else
                    <p class="text-lg text-gray-800 max-w-3xl mx-auto mt-4">
                        Experience refined living at NRN Building in Mission Hills, Roxas City - where comfort meets modern convenience.
                    </p>
                    @endisset
                </div>

                <!-- Image + Text Content -->
                <div class="flex flex-col md:flex-row gap-10 md:gap-16">
                    <!-- Left Image -->
                    <div class="w-full md:w-1/2 h-96 md:h-[500px] relative rounded-xl overflow-hidden shadow-lg">
                        <img src="images/NRNBUILDING.png" alt="NRN Building" 
                            class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
                    </div>

                    <!-- Right Text - Now perfectly aligned with image height -->
                    <div class="w-full md:w-1/2 flex flex-col justify-center"> <!-- Added flex container for vertical centering -->
                        <div class="mb-6">
                            <h3 class="font-san-serif text-3xl md:text-4xl lg:text-5xl text-gray-900 mb-2 leading-tight">
                                Designed for Comfort
                            </h3>
                        </div>
                        
                        @isset($settings->designed_description)
                        <p class="text-lg text-gray-800 max-w-6xl mx-auto mt-4 mb-4">
                            {{ $settings->designed_description }}
                        </p>
                        @else
                        <p class="text-lg text-gray-800 max-w-6xl mx-auto mt-4">
                            NRN Building features 30 thoughtfully designed rooms with premium amenities, secured parking, 
                            and modern comforts in the heart of Roxas City. Our spaces are crafted to provide an elevated 
                            living experience for both short and long-term residents.
                        </p>
                        @endisset

                        <!-- Features List -->
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="h-5 w-5 text-[#89CFF0]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-lg text-gray-800 max-w-6xl">30 elegant, fully-furnished rooms</span>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="h-5 w-5 text-[#89CFF0]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-lg text-gray-800 max-w-6xl">24/7 security and CCTV monitoring</span>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="h-5 w-5 text-[#89CFF0]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-lg text-gray-800 max-w-6xl">Free high-speed WiFi access</span>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="h-5 w-5 text-[#89CFF0]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-lg text-gray-600 max-w-6xl">Prime Mission Hills location</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
       <div id="nearby" class="scroll-mt-20"></div>
        <!-- Nearby Establishments Section -->
        <section class="bg-gray-50 py-12 md:py-18 px-4 md:px-8" data-aos="fade-up">
            <div class="max-w-full mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-12 md:mb-16">
                    <h3 class="font-san-serif text-3xl md:text-4xl lg:text-5xl text-gray-900 mb-6 leading-tight">Landmarks Near Our Residence</h3>
                    @isset($settings->neary_description)
                    <p class="text-lg text-gray-800 max-w-6xl mx-auto">{{ $settings->neary_description }}</p>
                    @else
                    <p class="text-lg text-gray-600 max-w-6xl mx-auto">
                        Discover premium amenities and cultural landmarks surrounding the NRN Building, offering unparalleled convenience and lifestyle opportunities within walking distance.
                    </p>
                    @endisset
                </div>

                <!-- Carousel Container -->
                <div class="relative group">
                    <div class="carousel-container overflow-hidden relative w-full">
                        <div class="carousel-wrapper flex transition-transform duration-500 ease-in-out" id="carousel">
                            @foreach($nearby as $establishment)
                                <div class="carousel-item w-full sm:w-1/2 md:w-1/3 lg:w-1/4 flex-shrink-0 px-3">
                                    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl h-full flex flex-col border border-gray-100">
                                        <div class="relative h-48 md:h-56 overflow-hidden">
                                            <img 
                                                src="{{ asset('storage/' . $establishment->image_url) }}" 
                                                alt="{{ $establishment->name }}" 
                                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                                                loading="lazy"
                                                width="400"
                                                height="300"
                                            >
                                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                                <span class="text-white font-medium text-sm bg-amber-500 px-3 py-1 rounded-full">
                                                    {{ $establishment->distance }} km
                                                </span>
                                            </div>
                                        </div>
                                        <div class="p-5 flex-grow flex flex-col">
                                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $establishment->name }}</h3>
                                            
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Carousel Navigation Buttons -->
                    <button 
                        class="carousel-prev absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 text-gray-800 rounded-full shadow-lg p-3 hover:bg-white transition-all opacity-0 group-hover:opacity-100"
                        aria-label="Previous slide"
                        onclick="prevSlide()"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15 19-7-7 7-7" />
                        </svg>
                    </button>
                    <button 
                        class="carousel-next absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 text-gray-800 rounded-full shadow-lg p-3 hover:bg-white transition-all opacity-0 group-hover:opacity-100"
                        aria-label="Next slide"
                        onclick="nextSlide()"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>
        <!-- Apartments Section -->
        <div id="rooms" class="scroll-mt-20"></div>
        <section class="bg-white py-12 md:py-16 px-4 md:px-8" data-aos="fade-up">
            <div class="max-w-full mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-8 md:mb-8">
                    <h2 class="font-san-serif text-3xl md:text-4xl lg:text-5xl text-gray-900 mb-6 leading-tight">Rooms We Offer</h2>
                    @isset($settings->apartment_description)
                    <p class="text-lg text-gray-800 max-w-6xl mx-auto">
                        {{ $settings->apartment_description }}
                    </p>
                    @else
                    <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-4xl mx-auto font-light">
                        Discover our meticulously selected residences, each offering an exceptional blend of comfort, style, and convenience in prime locations near the NRN Building.
                    </p>
                    @endisset
                </div>

                <!-- Apartment Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                    @foreach ($categories as $category)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl border border-gray-100 group">
                            <!-- Image Carousel -->
                            <div id="default-carousel-{{$category->category_id}}" class="relative" data-carousel="static">
                                <div class="overflow-hidden relative h-64 md:h-72 lg:h-80">
                                    @foreach ($images[$category->category_id] as $image)
                                    <div class="hidden duration-300 ease-in-out" data-carousel-item>
                                        <img src="{{ asset($image->image) }}" 
                                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                                            alt="{{ $category->category_name }} apartment image"
                                            loading="lazy"
                                            width="600"
                                            height="400">
                                    </div>
                                    @endforeach
                                </div>
                                
                                <!-- Carousel Indicators -->
                                @if($images[$category->category_id]->count() > 1)
                                <div class="flex absolute bottom-5 left-1/2 transform -translate-x-1/2 space-x-2 z-30">
                                    @for ($i = 0; $i < $images[$category->category_id]->count(); $i++)
                                        <button type="button" 
                                                class="w-2 h-2 rounded-full bg-white/50 hover:bg-white transition-colors" 
                                                aria-current="false" 
                                                aria-label="Slide {{$i+1}}" 
                                                data-carousel-slide-to="{{$i}}">
                                        </button>
                                    @endfor
                                </div>
                                @endif
                                
                                <!-- Navigation Arrows -->
                                @if($images[$category->category_id]->count() > 1)
                                <button type="button" 
                                        class="absolute top-1/2 left-4 z-30 flex items-center justify-center w-10 h-10 rounded-full bg-white/80 text-gray-800 shadow-md hover:bg-white transition-all opacity-0 group-hover:opacity-100 -translate-y-1/2" 
                                        data-carousel-prev>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                <button type="button" 
                                        class="absolute top-1/2 right-4 z-30 flex items-center justify-center w-10 h-10 rounded-full bg-white/80 text-gray-800 shadow-md hover:bg-white transition-all opacity-0 group-hover:opacity-100 -translate-y-1/2" 
                                        data-carousel-next>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                                @endif
                            </div>

                            <!-- Apartment Details -->
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-xl font-san-serif font-semibold text-gray-900">{{ $category->category_name }}</h3>
                                    <span class="text-blue-600 font-medium">₱{{ number_format($category->price, 0) }}/mo</span>
                                </div>

                                <div class="flex items-center text-gray-600 mb-4">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Capacity: {{ $category->description['pax'] }} residents</span>
                                </div>

                                <!-- Key Features -->
                                <div class="mb-6">
                                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Amenities:</h4>
                                    <div class="grid grid-cols-2 gap-2">
                                        @php
                                            $features = [
                                                ['condition' => $category->description['aircon'], 'icon' => 'M8 9l4-4 4 4m0 6l-4 4-4-4', 'label' => 'Air Conditioning'],
                                                ['condition' => $category->description['cr'], 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Private Bath'],
                                                ['condition' => $category->description['kitchen'], 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'label' => 'Kitchen'],
                                                ['condition' => $category->description['balcony'], 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Balcony']
                                            ];
                                        @endphp

                                        @foreach($features as $feature)
                                            @if($feature['condition'])
                                            <div class="flex items-center text-sm text-gray-700">
                                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"></path>
                                                </svg>
                                                {{ $feature['label'] }}
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <!-- View Details Button -->
                                <button wire:click="viewDetails({{ $category->category_id }})" 
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                                    View Full Details
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
                <script>
                    let currentIndex = 0;
                    const carousel = document.getElementById('carousel');
                    const items = document.querySelectorAll('.carousel-item');
                    const totalItems = items.length;
                
                    function updateCarousel() {
                        const offset = -currentIndex * 100;
                        carousel.style.transform = `translateX(${offset}%)`;
                    }
                
                    function nextSlide() {
                        if (currentIndex < totalItems - 1) {
                            currentIndex++;
                        } else {
                            currentIndex = 0; // Loop back to the first item
                        }
                        updateCarousel();
                    }
                
                    function prevSlide() {
                        if (currentIndex > 0) {
                            currentIndex--;
                        } else {
                            currentIndex = totalItems - 1; // Loop back to the last item
                        }
                        updateCarousel();
                    }
                </script>

      <!-- Footer -->
        <footer id="contact" class="bg-gray-900 text-white py-16">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                
                <!-- Contact Info -->
                <div class="md:col-span-1">
                    <h3 class="text-xl font-bold mb-6">Contact Information</h3>
                    @isset($owner)
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-1 mr-4 text-blue-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold">Property Manager</h4>
                                <p>{{ $owner->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-1 mr-4 text-blue-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold">Email</h4>
                                <a href="mailto:{{ $owner->email }}" class="hover:text-blue-400">{{ $owner->email }}</a>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-1 mr-4 text-blue-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold">Phone</h4>
                                <a href="tel:{{ $owner->phone_number }}"
                                    class="hover:text-blue-400">{{ $owner->phone_number }}</a>
                            </div>
                        </div>
                    </div>
                    @else
                    <p class="text-gray-400">Contact information not available.</p>
                    @endisset
                </div>

                <!-- Quick Links -->
                <div class="md:col-span-1">
                    <h3 class="text-xl font-bold mb-6">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="#about-us" class="hover:text-blue-400 transition duration-300">About NRN Building</a></li>
                        <li><a href="#rooms" class="hover:text-blue-400 transition duration-300">Apartment Options</a></li>
                        <li><a href="#nearby" class="hover:text-blue-400 transition duration-300">Nearby Establishments</a></li>
                        <li><a href="#location" class="hover:text-blue-400 transition duration-300">Location</a></li>
                    </ul>
                </div>

                <!-- Visit Us -->
                <div class="md:col-span-2">
                    <h3 class="text-xl font-bold mb-6">Visit Us</h3>
                    <div class="bg-gray-800 rounded-lg p-5">
                        <h4 class="font-semibold mb-2">NRN Building</h4>
                        <p class="text-gray-300 mb-4">Mission Hills Avenue, Roxas City, Capiz, Philippines</p>
                        <div class="rounded-lg overflow-hidden shadow-lg">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3908.8019578203007!2d122.76057597408091!3d11.56605044413493!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a5f3009ecc8dab%3A0x145584f32319a34c!2sMission%20Hills%20Ave%2C%20Roxas%20City%2C%20Capiz!5e0!3m2!1sen!2sph!4v1728137691267!5m2!1sen!2sph"
                                width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                                class="rounded-lg"></iframe>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-gray-700 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} NRN Building. All rights reserved.</p>
                <p class="mt-2 text-sm">Designed for comfortable living in Roxas City</p>
            </div>
        </div>
    </footer>



    </div>
</div>