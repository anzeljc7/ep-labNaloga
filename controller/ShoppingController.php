<?php

require_once("model/ItemDB.php");
require_once("model/ItemImageDB.php");
require_once("ViewHelper.php");
require_once("forms/ItemsForm.php");

class ShoppingController {

    public static function index() {
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $data = filter_input_array(INPUT_GET, $rules);
        if ($data !== null && isset($data["id"])) {
            $inputParameters['item_id'] = $data["id"];
            echo ViewHelper::render("view/items/available-item-detail.php", [
                "item" => ItemDB::get($inputParameters),
                "cartItems" => self::getItemsFromSession()
            ]);
        } else {
            echo ViewHelper::render("view/items/available-item-list.php", [
                "items" => ItemDB::getAllActive(),
                "cartItems" => self::getItemsFromSession()
            ]);
        }
    }

    public static function addToCart() {
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $data = filter_input_array(INPUT_POST, $rules);
        $id = $data["id"];
        
        if (isset($_SESSION["cart"][$id])) {
                    $_SESSION["cart"][$id]++;
                } else {
                    $_SESSION["cart"][$id] = 1;
        }
        
        echo ViewHelper::render("view/items/available-item-list.php", [
                "items" => ItemDB::getAllActive(),
                "cartItems" => self::getItemsFromSession()
            ]);
    }

    public static function deleteFromCart() {
        unset($_SESSION["cart"]);
        echo ViewHelper::render("view/items/available-item-list.php", [
                "items" => ItemDB::getAllActive(),
                "cartItems" => self::getItemsFromSession()
            ]);
    }
    
    public static function updateCart(){
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ],
            "qty" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 0]
            ]
        ];

        $data = filter_input_array(INPUT_POST, $rules);
        $id = $data["id"];
        $qty = $data["qty"];

        if($qty == 0){
                unset($_SESSION["cart"][$id]);
                if(count($_SESSION["cart"]) == 0 ){
                    unset($_SESSION["cart"]);  
                }        
            }
            else{
                $_SESSION["cart"][$id] = $qty;
            }
            
        echo ViewHelper::render("view/items/available-item-list.php", [
                "items" => ItemDB::getAllActive(),
                "cartItems" => self::getItemsFromSession()
            ]);
    }
    
    public static function confirmOrder() {
        $cartItems = self::getItemsFromSession();
        
        
        
    }

    private static function getItemsFromSession() {
        $totalValue = 0;

        if (isset($_SESSION["cart"])) {
            foreach ($_SESSION["cart"] as $id => $quantity) {
                $queryParams["item_id"] = $id;
                $item       = ItemDB::get($queryParams);
                $cartItems["items"][$id]= $item;
                $cartItems["items"][$id]['qty'] = $quantity;
                $totalValue += $quantity * $item['price'];
            }
            $cartItems['total'] = $totalValue;
            return $cartItems;
        } else {
            return [];
        }
    }
}
