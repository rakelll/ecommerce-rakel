<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;

#[Title('Cart-DCodeMania')]
class CartPage extends Component
{
    public $cart_items = [];

    public $subtotal = 0;
    public $taxes = 0;
    public $total = 0;
    public $taxRate = 0.11; // 11% tax rate

    public function mount()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();

        // Calculate the totals when the component is mounted
        $this->calculateTotals();
    }

    public function removeItem($product_id)
    {
        $this->cart_items = CartManagement::removeCartItem($product_id);
        $this->calculateTotals();
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))->to(Navbar::class);
    }

    public function increaseQty($product_id)
    {
        $this->cart_items = CartManagement::incrementQuantityToCartItem($product_id);
        $this->calculateTotals();
    }

    public function decreaseQty($product_id)
    {
        $this->cart_items = CartManagement::decrementQuantityToCartItem($product_id);
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = 0;
        $this->taxes = 0;

        foreach ($this->cart_items as $item) {
            $itemSubtotal = $item['unit_amount'] * $item['quantity'];
            $itemTax = $itemSubtotal * $this->taxRate;
            $this->subtotal += $itemSubtotal;
            $this->taxes += $itemTax;
        }

        // Calculate total by adding taxes to the subtotal
        $this->total = $this->subtotal + $this->taxes;
    }

    public function render()
    {
        return view('livewire.cart-page', [
            'cart_items' => $this->cart_items,
            'subtotal' => $this->subtotal,
            'taxes' => $this->taxes,
            'total' => $this->total,
        ]);
    }
}
