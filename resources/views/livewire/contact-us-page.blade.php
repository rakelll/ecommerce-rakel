<div class="container mx-auto mt-10">
    <h1 class="mb-6 text-3xl font-bold text-center">Contact Us</h1>
    <div class="grid grid-cols-1 gap-8 mt-6 md:grid-cols-2">

        <!-- Left Section for Address, Phone, and Email -->
        <div class="flex flex-col">
            <div class="p-6 mb-4 bg-white rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold">Address</h2>
                <p class="mt-2 text-gray-600">{{ $address }}</p>
            </div>

            <div class="p-6 mb-4 bg-white rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold">Phone</h2>
                <p class="mt-2 text-gray-600">
                    <a href="tel:{{ $phone1 }}" class="text-blue-600 hover:underline">{{ $phone1 }}</a>
                </p>
                <p class="mt-1 text-gray-600">
                    <a href="tel:{{ $phone2 }}" class="text-blue-600 hover:underline">{{ $phone2 }}</a>
                </p>
            </div>

            <div class="p-6 bg-white rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold">Email</h2>
                <p class="mt-2 text-gray-600">
                    <a href="mailto:{{ $email }}" class="text-blue-600 hover:underline">{{ $email }}</a>
                </p>
            </div>
        </div>

        <!-- Right Section for Google Maps Location -->
        <div class="p-6 mb-10 bg-white rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold">Our Location on Google Maps</h2>
            <div class="mt-4">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3312.1076222957818!2d35.559182799999995!3d33.886882!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151f171af0307c79%3A0x7b25a6e737f45ba8!2sTeSec!5e0!3m2!1sen!2slb!4v1740225405451!5m2!1sen!2slb"
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
    <!-- Footer Space -->
    <div class="mt-10 mb-6"></div>
</div>
