<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="py-10 rounded-lg bg-gray-50 font-poppins dark:bg-gray-800">
        <div class="px-4 py-4 mx-auto max-w-7xl lg:py-6 md:px-6">
            <div class="flex flex-wrap mb-24 -mx-3">
                <div class="w-full pr-2 lg:w-1/4 lg:block">
                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:border-gray-900 dark:bg-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400"> Categories</h2>
                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                        <ul>
                            @foreach ($categories as $category)
                                <li class="mb-4" wire:key="{{ $category->id }}">
                                    <label for="{{ $category->slug }}" class="flex items-center dark:text-gray-400 ">
                                        <input type="checkbox" wire:model.live="selected_categories"
                                            id="{{ $category->slug }}" value="{{ $category->id }}" class="w-4 h-4 mr-2">
                                        <span class="text-lg">{{ $category->name }}</span>
                                    </label>
                                </li>
                            @endforeach


                        </ul>

                    </div>
                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400">Brand</h2>
                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                        <ul>
                            @foreach ($brands as $brand)
                                <li class="mb-4" wire:key="{{ $brand->id }}">
                                    <label for="{{ $brand->slug }}" class="flex items-center dark:text-gray-300">
                                        <input type="checkbox" wire:model.live="selected_brands"
                                            id="{{ $brand->slug }}" value="{{ $brand->id }}" class="w-4 h-4 mr-2">
                                        <span class="text-lg dark:text-gray-400">{{ $brand->name }}</span>
                                    </label>
                                </li>
                            @endforeach


                        </ul>
                    </div>
                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400">Product Status</h2>
                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                        <ul>
                            <li class="mb-4">
                                <label for="featured" class="flex items-center dark:text-gray-300">
                                    <input type="checkbox" wire:model.live="featured" id="featured"
                                        class="w-4 h-4 mr-2" value="1">
                                    <span class="text-lg dark:text-gray-400">Featured Products</span>
                                </label>
                            </li>
                            <li class="mb-4">
                                <label for="on_sale" class="flex items-center dark:text-gray-300">
                                    <input type="checkbox" wire:model.live="on_sale" id="on_sale" class="w-4 h-4 mr-2"
                                        value="1">
                                    <span class="text-lg dark:text-gray-400">On Sale</span>
                                </label>
                            </li>
                        </ul>
                    </div>

                    <div class="p-4 mb-5 bg-white border border-WHITE-200 dark:bg-WHITE-900 dark:border-WHITE-900">
                        {{-- <h2 class="text-2xl font-bold dark:text-gray-400">Price</h2> --}}
                        {{-- <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div> --}}
                        <div>
                            {{-- <div class="font-semibold">{{ Number::currency($price_range) }}</div> --}}
                            {{-- <input type="range" wire:model.live="price_range"
                                class="w-full h-1 mb-4 bg-blue-100 rounded appearance-none cursor-pointer"
                                max="500000" value="300000" step="100"> --}}
                            <div class="flex justify-between ">
                                {{-- <span
                                    class="inline-block text-lg font-bold text-blue-400 ">{{ Number::currency(100) }}</span>
                                <span
                                    class="inline-block text-lg font-bold text-blue-400 ">{{ Number::currency(5000) }}</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full px-3 lg:w-3/4">
                    <div class="px-3 mb-4">
                        <div class="hidden px-3 py-2 bg-gray-100 md:flex dark:bg-gray-900"></div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                        @foreach ($products as $product)
                            <div
                                class="overflow-hidden border border-gray-300 rounded-lg shadow-md dark:border-gray-700">
                                <div class="relative bg-gray-200">
                                    <a href="/products/{{ $product->slug }}">
                                        <img src="{{ url('storage', $product->images[0]) }}"
                                            alt="{{ $product->name }}" class="object-cover w-full h-56">
                                    </a>
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold dark:text-gray-300">
                                        {{ $product->name }}
                                    </h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>




            </div>
            <!-- pagination start -->
            <div class="flex justify-end mt-6">
                {{ $products->links() }}
            </div>
            <!-- pagination end -->
        </div>
</div>
</div>
</section>

</div>
