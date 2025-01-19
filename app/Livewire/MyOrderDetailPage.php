<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\attributes\title;
use Livewire\Component;

#[Title ('Order Detail')]
class MyOrderDetailPage extends Component
{
   public $order_id;
    public function mount ($order_id){
        $this->order_id=$order_id;

    }



    public function render()
    {
        $order_items = OrderItem::with('product')->where('order_id', $this->order_id)->get();
        $address = Address::where('order_id', $this->order_id)->first();
        $order = Order::where('id', $this->order_id)->first();

        // Calculate the subtotal
        $subtotal = $order_items->sum(function ($item) {
            return $item->unit_amount * $item->quantity;
        });

        return view('livewire.my-order-detail-page', [
            'order_items' => $order_items,
            'address' => $address,
            'order' => $order,
            'subtotal' => $subtotal, // Pass the subtotal to the view
        ]);
    }
}
