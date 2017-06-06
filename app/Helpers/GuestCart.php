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
            if(isset($guestItems[$item->id])) {
                $item->quantity = $guestItems[$item->id];
            }
            unset($guestItems[$item->id]);
        }
        if(! is_null($guestItems) && ! empty($guestItems)) {
            foreach ($guestItems as $id => $quantity) {
                $product = Product::find($id);
                $cartDetail = \Auth::user()->cart->cartDetails->where("product_id", "=", $id);
                if ($cartDetail->isEmpty()) {
                    $cartDetail = new CartDetail;
                } else {
                    $cartDetail = $cartDetail->first();
                }
                $cartDetail->quantity = $quantity;
                $cartDetail->product()->associate($product);
                $cartDetail->cart()->associate(\Auth::user()->cart);
                $cartDetail->save();
            }
        }
    }

}