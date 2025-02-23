<div>
    <div class="w-full h-screen px-4 py-10 mx-auto sm:px-6 lg:px-8">
        <div class="relative w-full h-full">
            <!-- Image as background with object-fit to maintain quality -->
            <img class="absolute top-0 left-0 object-cover object-center w-full h-full rounded-md"
                src="{{ asset('images/christina-wocintechchat-com-eAXpbb4vzKU-unsplash.jpg') }}" alt="Image Description">

            <!-- Content on top of image -->
            <div class="relative z-10 max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1
                    class="block px-4 py-2 text-3xl font-bold text-black bg-gray-200 sm:text-4xl lg:text-6xl lg:leading-tight">
                    Start your journey with <span class="text-blue-600">TESEC</span>
                </h1>


                <p class="mt-3 text-lg text-black">
                    <span class="inline-block px-2 py-1 bg-gray-200">
                        Purchase wide varieties of electronics products like Smartphones, Laptops, Smartwatches,
                        Television,
                        and many more.
                    </span>
                </p>
            </div>
        </div>
    </div>




    <section class="py-20">
        <div class="max-w-xl mx-auto">
            <div class="text-center ">
                <div class="relative flex flex-col items-center">
                    <h1 class="text-5xl font-bold dark:text-gray-200"> Browse Popular<span class="text-blue-500">
                            Brands
                        </span> </h1>
                    <div class="flex w-40 mt-2 mb-6 overflow-hidden rounded">
                        <div class="flex-1 h-2 bg-blue-200">
                        </div>
                        <div class="flex-1 h-2 bg-blue-400">
                        </div>
                        <div class="flex-1 h-2 bg-blue-600">
                        </div>
                    </div>
                </div>
                <p class="mb-12 text-base text-center text-gray-500">
                    Explore a wide selection of top-quality brands offering the latest in electronics, gadgets, and
                    accessories. Whether you’re looking for smartphones, laptops, or smartwatches, we have the best
                    options
                    for you to choose from. Stay ahead with the most trusted names in technology.
                </p>
                </p>
            </div>
        </div>
        <div class="justify-center max-w-6xl px-4 py-4 mx-auto lg:py-0">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-4 md:grid-cols-2">

                @foreach ($brands as $brand)
                    <div class="bg-white rounded-lg shadow-md dark:bg-gray-800" wire:key="{{ $brand->id }}">
                        <a href="/products?selected_brands[0]={{ $brand->id }}" class="">
                            <img src="{{ url('storage', $brand->image) }}" alt="{{ $brand->name }}"
                                class="object-cover w-full h-64 rounded-t-lg">
                        </a>
                        <div class="p-5 text-center">
                            <a href=""
                                class="text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-300">
                                {{ $brand->name }}
                            </a>
                        </div>
                    </div>
                @endforeach







            </div>
        </div>
    </section>
    <div class="py-20 bg-orange-200">
        <div class="max-w-xl mx-auto">
            <div class="text-center ">
                <div class="relative flex flex-col items-center">
                    <h1 class="text-5xl font-bold dark:text-gray-200"> Browse <span class="text-blue-500">
                            Categories
                        </span> </h1>
                    <div class="flex w-40 mt-2 mb-6 overflow-hidden rounded">
                        <div class="flex-1 h-2 bg-blue-200">
                        </div>
                        <div class="flex-1 h-2 bg-blue-400">
                        </div>
                        <div class="flex-1 h-2 bg-blue-600">
                        </div>
                    </div>
                </div>
                <p class="mb-12 text-base text-center text-gray-500">
                    Discover a diverse range of product categories tailored to meet your needs. From electronics to
                    fashion,
                    home appliances to gadgets, find everything you’re looking for in one place. Shop the best products
                    in
                    each category, selected to bring you quality and value.
                </p>
            </div>
        </div>

        <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto">
            <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 sm:gap-6">



                @foreach ($categories as $category)
                    <a class="flex flex-col transition bg-white border shadow-sm group rounded-xl hover:shadow-md dark:bg-slate-900 dark:border-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                        href="/products?selected_categories[0]={{ $category->id }}" wire:key="{{ $category->id }}">
                        <div class="p-4 md:p-5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="h-[2.375rem] w-[2.375rem] rounded-full"
                                        src="{{ url('storage', $category->image) }}" alt="$category->name">
                                    <div class="ms-3">
                                        <h3
                                            class="font-semibold text-gray-800 group-hover:text-blue-600 dark:group-hover:text-gray-400 dark:text-gray-200">
                                            {{ $category->name }}
                                        </h3>
                                    </div>
                                </div>
                                <div class="ps-3">
                                    <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach




            </div>
        </div>

    </div>
    <section class="py-14 font-poppins dark:bg-gray-800">
        <div class="max-w-6xl px-4 py-6 mx-auto lg:py-4 md:px-6">
            <!-- Section Header -->
            <div class="mb-8 text-center">
                <h1 class="text-5xl font-bold dark:text-gray-200">Customer <span class="text-blue-500">Reviews</span>
                </h1>
            </div>

            <!-- Move the line under the heading -->
            <div class="flex w-40 mx-auto mt-2 mb-6 overflow-hidden rounded">
                <div class="flex-1 h-2 bg-blue-200"></div>
                <div class="flex-1 h-2 bg-blue-400"></div>
                <div class="flex-1 h-2 bg-blue-600"></div>
            </div>

            <!-- Reviews Grid -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Review Card -->
                <div class="py-6 bg-white rounded-md shadow dark:bg-gray-900">
                    <div
                        class="flex flex-wrap items-center justify-between pb-4 mb-6 space-x-2 border-b dark:border-gray-700">
                        <div class="flex items-center px-6 mb-2 md:mb-0">
                            <img src="{{ asset('images/Untitled design (8).png') }}" alt="Customer Logo"
                                class="w-12 h-12 rounded-full">
                            <h2 class="ml-3 text-lg font-semibold dark:text-gray-200">TotalCare</h2>
                        </div>
                    </div>
                    <p class="px-6 mb-6 text-base text-gray-500 dark:text-gray-400">
                        I had the pleasure of working with Tesec Sarl for the installation of a CCTV system, and I
                        couldn’t be more satisfied. They traveled to our location and handled the installation with
                        remarkable efficiency and expertise. Their dedication to customer satisfaction is truly
                        commendable.
                    </p>
                </div>

                <!-- Repeat for each review -->
                <div class="py-6 bg-white rounded-md shadow dark:bg-gray-900">
                    <div
                        class="flex flex-wrap items-center justify-between pb-4 mb-6 space-x-2 border-b dark:border-gray-700">
                        <div class="flex items-center px-6 mb-2 md:mb-0">
                            <img src="{{ asset('images/amana-capital-logo-post.jpg') }}" alt="Customer Logo"
                                class="w-12 h-12 rounded-full">
                            <h2 class="ml-3 text-lg font-semibold dark:text-gray-200">Amana Capital</h2>
                        </div>
                    </div>
                    <p class="px-6 mb-6 text-base text-gray-500 dark:text-gray-400">
                        I had an excellent experience with Tesec Sarl. They traveled with us and took care of all our IT
                        equipment needs, ensuring we got the best products suited to our requirements. I appreciate
                        their dedication and the effort they put into finding the right solutions for us.
                    </p>
                </div>

                <div class="py-6 bg-white rounded-md shadow dark:bg-gray-900">
                    <div
                        class="flex flex-wrap items-center justify-between pb-4 mb-6 space-x-2 border-b dark:border-gray-700">
                        <div class="flex items-center px-6 mb-2 md:mb-0">
                            <img src="{{ asset('images/Untitled design (7).png') }}" alt="Customer Logo"
                                class="w-12 h-12 rounded-full">
                            <h2 class="ml-3 text-lg font-semibold dark:text-gray-200">Sucafina</h2>
                        </div>
                    </div>
                    <p class="px-6 mb-6 text-base text-gray-500 dark:text-gray-400">
                        Working with Tesec Sarl was an absolute pleasure. They went above and beyond to source and
                        purchase all the IT equipment we needed.
                        Their commitment to ensuring we got the best products at the most competitive prices was truly
                        impressive.</p>
                </div>

                <div class="py-6 bg-white rounded-md shadow dark:bg-gray-900">
                    <div
                        class="flex flex-wrap items-center justify-between pb-4 mb-6 space-x-2 border-b dark:border-gray-700">
                        <div class="flex items-center px-6 mb-2 md:mb-0">
                            <img src="{{ asset('images/Untitled design (6).png') }}" alt="Customer Logo"
                                class="w-12 h-12 rounded-full">
                            <h2 class="ml-3 text-lg font-semibold dark:text-gray-200">Académie Libanaise des Beaux-Arts
                            </h2>
                        </div>
                    </div>
                    <p class="px-6 mb-6 text-base text-gray-500 dark:text-gray-400">
                        Tesec Sarl exceeded our expectations by traveling with us and handling the purchase of all our
                        IT equipment. Their professionalism and expertise were evident throughout the process.
                        They guided us in choosing the best products and ensured everything was delivered on time.</p>
                </div>
            </div>
        </div>
    </section>
