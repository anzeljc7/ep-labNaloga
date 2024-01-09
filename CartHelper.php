<?php

require_once("model/ItemDB.php");

class CartHelper {

    public static function getItemsFromSession() {
        $totalValue = 0;

        if (isset($_SESSION["cart"])) {
            foreach ($_SESSION["cart"] as $id => $quantity) {
                $queryParams["item_id"]         = $id;
                $item                           = ItemDB::get($queryParams);
                $cartItems["items"][$id]        = $item;
                $cartItems["items"][$id]['qty'] = $quantity;
                $totalValue                     += $quantity * $item['price'];
            }
            $cartItems['total'] = $totalValue;
            return $cartItems;
        } else {
            return [];
        }
    }
    
    public static function getCartSize() {
        if (isset($_SESSION["cart"])) {
            return sizeof($_SESSION["cart"]);
        } else {
            return 0;
        }
    }
}
