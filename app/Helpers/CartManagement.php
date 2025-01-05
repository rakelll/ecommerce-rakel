<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartManagement{
    //add item to cart
    static public function addItemToCart($product_id){
        $cart_items=self::getCartItemsFromCookie();
        $existing_item=null;
        foreach ($cart_items as $key => $item){
            if($item['product_id']==$product_id){
              $existing_item=$key;
              break;
            }
        }
        if($existing_item !==null){
            $cart_items[$existing_item]['quantity']++;
            $cart_items[$existing_item]['total_amount']=$cart_items[$existing_item]['quantity']*$cart_items[$existing_item]['unit_amount'];
        }
        else{
            $product=Product::where('id',$product_id)->first(['id','name','price','images']);
            if ($product){
                $cart_items[] = [
                    'product_id'=>$product_id,
                    'name'=>$product->name,
                    'image'=>$product->images[0],
                    'quantity'=>1,
                    'unit_amount'=>$product->price,
                    'total_amount'=>$product->price,


                ];
            }
        }
        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }
     // Add item to cart with specified quantity
static public function addItemToCartWithQty($product_id, $qty)
{
    $cart_items = self::getCartItemsFromCookie();
    $existing_item = null;

    foreach ($cart_items as $key => $item) {
        if ($item['product_id'] == $product_id) {
            $existing_item = $key;
            break;
        }
    }

    if ($existing_item !== null) {
        $cart_items[$existing_item]['quantity'] = $qty;
        $cart_items[$existing_item]['total_amount'] = $qty * $cart_items[$existing_item]['unit_amount'];
    } else {
        $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);
        if ($product) {
            $cart_items[] = [
                'product_id' => $product_id,
                'name' => $product->name,
                'image' => $product->images[0],
                'quantity' => $qty,
                'unit_amount' => $product->price,
                'total_amount' => $qty * $product->price,
            ];
        }
    }

    self::addCartItemsToCookie($cart_items);
    return count($cart_items);
}

    //remove item from cart
  // Remove item from cart
static public function removeCartItem($product_id)
{
    $cart_items = self::getCartItemsFromCookie();

    // Filter out the item with the given product_id
    $cart_items = array_filter($cart_items, function($item) use ($product_id) {
        return $item['product_id'] != $product_id;
    });

    // Reindex the array
    $cart_items = array_values($cart_items);

    // Update the cookie with the modified cart items
    self::addCartItemsToCookie($cart_items);

    return $cart_items;
}



    // Add cart items to cookie
    // Add cart items to cookie
static public function addCartItemsToCookie($cart_items)
{
    Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30); // 30 days expiry
}


    // Clear cart items from cookie
    static public function clearCartItems(){
        Cookie::queue(Cookie::forget('cart_items'));
    }

    // Get all cart items from cookie
    static public function getCartItemsFromCookie(){
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if(!$cart_items){
            $cart_items = [];
        }
        return $cart_items;
    }
    //increment item quantity
    static public function incrementQuantityToCartItem($product_id){
        $cart_items=self::getCartItemsFromCookie();
        foreach($cart_items as $key=> $item){
            if ($item['product_id'] == $product_id){
                $cart_items[$key]['quantity']++;
                $cart_items[$key]['total_amount']=$cart_items[$key]['quantity']*$cart_items[$key]['unit_amount'];
            }
            }
            self::addCartItemsToCookie($cart_items);
            return $cart_items;
        }

        // decrement item quantity
        static public function decrementQuantityToCartItem($product_id){
            $cart_items=self::getCartItemsFromCookie();
            foreach($cart_items as $key=> $item){
                if ($item['product_id'] == $product_id){
                    if ($cart_items[$key]['quantity']>1){


                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount']=$cart_items[$key]['quantity']*$cart_items[$key]['unit_amount'];
                }
                }
            }
                self::addCartItemsToCookie($cart_items);
                return $cart_items;
            }
            public static function CalculateGrandTotal($cart_items)
            {
                $totalAmount = 0;
                $taxAmount = 0;
                $taxRate = 0.11; // 11% tax

                foreach ($cart_items as $item) {
                    $itemTotal = $item['unit_amount'] * $item['quantity'];
                    $totalAmount += $itemTotal;
                    $taxAmount += $itemTotal * $taxRate;
                }

                $grandTotal = $totalAmount + $taxAmount;

                return [
                    'total_amount' => $totalAmount,
                    'tax_amount' => $taxAmount,
                    'grand_total' => $grandTotal,
                ];
            }

    }

