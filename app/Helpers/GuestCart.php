<?php

namespace App\Helpers;
use App\Product;
use App\CartDetail;

class GuestCart {
    public static function getAllProductsCount($items) {
        $count = 0;
        if(! is_null($items)) {
            foreach ($items as $item) {
                $count++;
            }
        }
        return $count;
    }

    public static function getAllProducts($items) {
        $products = [];

        if(! is_null($items)) {
            foreach($items as $id => $quantity) {
                $price = Product::find($id)->price;
                array_push($products, ["price" => $price, "quantity" => $quantity, ""]);
            }
        }
    }

    public static function merge($guestItems, $userItems) {
        foreach($userItems as $item) {
            if(isset($guestItems[$item->product_id])) {
                $item->quantity = $guestItems[$item->product_id];
            }
            $item->save();
            unset($guestItems[$item->product_id]);
        }
        if(count($guestItems)) {
            foreach ($guestItems as $id => $quantity) {
                $product = Product::find($id);
                $cartDetail = new CartDetail;
                $cartDetail->quantity = $quantity;
                $cartDetail->product()->associate($product);
                $cartDetail->cart()->associate(\Auth::user()->cart);
                $cartDetail->save();
            }
        }
    }

}