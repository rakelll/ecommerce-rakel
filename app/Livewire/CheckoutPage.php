<?php

namespace App\Livewire;

use Stripe\Stripe;
use App\Models\Order;
use App\Models\Address;
use Livewire\Component;
use App\Mail\OrderPlaced;
use App\Models\OrderItem;
use Stripe\Checkout\Session;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

#[Title('checkout')]
class CheckoutPage extends Component
{
    public $first_name;
    public $last_name;
    public $phone;
    public $street_address;
    public $city;
    public $state;
    public $zip_code;
    public $payment_method;
    public $cart_items = [];
    public $totalAmount = 0;
    public $taxAmount = 0;
    public $grandTotal = 0;
    public function fount(){
$cart_items=CartManagement::getCartItemsFromCookie();
if(count($cart_items)==0){
    return redirect('/products');
}
    }
    public function placeOrder()
    {

        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'payment_method' => 'required',
        ]);

        // Get cart items from the cookie or session
        $cart_items = CartManagement::getCartItemsFromCookie();

        // Calculate totals
        $totals = CartManagement::CalculateGrandTotal($cart_items);
        $this->totalAmount = $totals['total_amount'];
        $this->taxAmount = $totals['tax_amount'];
        $this->grandTotal = $totals['grand_total'];

        // Create a new Order
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->grand_total = $this->grandTotal; // Total amount including tax
        $order->tax_amount = $this->taxAmount; // Tax amount
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status = 'new';
        $order->currency = 'usd';
        $order->shipping_amount = 0;
        $order->shipping_method = 'none';
        $order->notes = 'Order placed by ' . auth()->user()->name;
        $order->save();

        // Save the address and link it to the order
        $address = new Address();
        $address->order_id = $order->id;
        $address->first_name = $this->first_name;
        $address->last_name = $this->last_name;
        $address->phone = $this->phone;
        $address->street_address = $this->street_address;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->zip_code = $this->zip_code;
        $address->save();

        // Save order items
        foreach ($cart_items as $item) {
            $unitAmount = $item['unit_amount'];
            $quantity = $item['quantity'];
            $tva = $unitAmount * 0.11; // 11% TVA
            $totalAmount = ($unitAmount + $tva) * $quantity; // Total amount including TVA

            // Create the order item with tax amount
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $quantity,
                'unit_amount' => $unitAmount,
                'tax_amount' => $tva, // Store the tax amount
                'total_amount' => $totalAmount,
            ]);
        }

        // Clear the cart
        CartManagement::clearCartItems();

        // Prepare line items for Stripe
        $line_items = [];
        foreach ($cart_items as $item) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $item['unit_amount'] * 100, // Amount in cents
                    'product_data' => [
                        'name' => $item['name'], // Ensure you have this field
                    ],
                ],
                'quantity' => $item['quantity'],
            ];
        }

        // Add tax to line items
        $line_items[] = [
            'price_data' => [
                'currency' => 'usd',
                'unit_amount' => $this->taxAmount * 100, // Tax amount in cents
                'product_data' => [
                    'name' => 'Tax',
                ],
            ],
            'quantity' => 1,
        ];

        // Handle payment processing
        if ($this->payment_method == 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $sessionCheckout = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => auth()->user()->email,
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel'),
            ]);
            $redirect_url = $sessionCheckout->url;
        } else {
            $redirect_url = route('success');
        }
        Mail::to(auth()->user())->send(new OrderPlaced($order));

        return redirect($redirect_url);
    }

    public function mount()
    {
        $this->fount();
        // Get cart items from the cookie or session
        $this->cart_items = CartManagement::getCartItemsFromCookie();

        // Calculate totals
        $totals = CartManagement::CalculateGrandTotal($this->cart_items);

        // Extract values from the returned array
        $this->totalAmount = $totals['total_amount'];
        $this->taxAmount = $totals['tax_amount'];
        $this->grandTotal = $totals['grand_total'];
    }

    public function render()
    {
        return view('livewire.checkout-page', [
            'cart_items' => $this->cart_items,
            'totalAmount' => $this->totalAmount,
            'taxAmount' => $this->taxAmount,
            'grandTotal' => $this->grandTotal,
        ]);
    }
}
