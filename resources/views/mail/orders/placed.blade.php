<x-mail::message>
    # Order placed successfully!

    Thank you for your order.

    <x-mail::button :url="$url">
        View Order
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
