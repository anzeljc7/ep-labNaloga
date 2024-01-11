<?php

require_once("model/ItemDB.php");
require_once("model/OrderDB.php");
require_once("model/AuthDB.php");
require_once("model/PostNumDB.php");
require_once("model/OrderItemDB.php");
require_once("model/ItemImageDB.php");
require_once("ViewHelper.php");
require_once("CartHelper.php");
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
                "cartItems" => CartHelper::getItemsFromSession()
            ]);
        } else {
            $items = ItemDB::getAllActive();
            foreach ($items as $key => $item) {
                $items[$key]['images'] = ItemImageDB::get(['item_id' => $item['item_id']]);
            }
            echo ViewHelper::render("view/items/available-item-list.php", [
            "items" => $items,
            "cartItems" => CartHelper::getItemsFromSession()
            ]);
        }
    }

    public static function cart() {

        echo ViewHelper::render("view/items/shopping-cart.php", [
            "cartItems" => CartHelper::getItemsFromSession()
        ]);
    }

    public static function addToCart() {
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $data = filter_input_array(INPUT_POST, $rules);
        $id   = $data["id"];

        if (isset($_SESSION["cart"][$id])) {
            $_SESSION["cart"][$id]++;
        } else {
            $_SESSION["cart"][$id] = 1;
        }

        echo ViewHelper::render("view/items/available-item-list.php", [
            "items" => ItemDB::getAllActive(),
            "cartItems" => CartHelper::getItemsFromSession()
        ]);
    }

    public static function deleteFromCart() {
        unset($_SESSION["cart"]);
        echo ViewHelper::render("view/items/available-item-list.php", [
            "items" => ItemDB::getAllActive(),
            "cartItems" => CartHelper::getItemsFromSession()
        ]);
    }

    public static function updateCart() {
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
        $id   = $data["id"];
        $qty  = $data["qty"];

        if ($qty == 0) {
            unset($_SESSION["cart"][$id]);
            if (count($_SESSION["cart"]) == 0) {
                unset($_SESSION["cart"]);
            }
        } else {
            $_SESSION["cart"][$id] = $qty;
        }

        echo ViewHelper::render("view/items/shopping-cart.php", [
            "items" => ItemDB::getAllActive(),
            "cartItems" => CartHelper::getItemsFromSession()
        ]);
    }

    public static function orderPreview() {
        $user        = AuthDB::getFullCurrentUser();
        $allowedKeys = ['user_id', 'name', 'surname', 'email'];
        $currentUser = array_intersect_key($user, array_flip($allowedKeys));

        $address['street']       = $user['street'];
        $address['house_number'] = $user['house_number'];
        $address['postal_code']  = $user['postal_code'];
        $post                    = PostNumDB::get(['postal_code' => $address['postal_code']]);
        $address['city']         = $post['city'];

        $currDate          = date('Y-m-d H:i:s');
        $cartItems         = CartHelper::getItemsFromSession();
        $cartItems['date'] = $currDate;

        echo ViewHelper::render("view/orders/order-preview.php", [
            "currentUser" => $currentUser,
            "address" => $address,
            "cartItems" => $cartItems
        ]);
    }

    public static function orderConfirm() {
        $cartItems = CartHelper::getItemsFromSession();
        $user      = AuthDB::getCurrentUser();
        $currDate  = date('Y-m-d H:i:s');

        $orderParams['user_id']    = $user['user_id'];
        $orderParams['status_id']  = ORDER_PENDING;
        $orderParams['order_date'] = $currDate;
        $orderParams['total']      = $cartItems['total'];

        $orderId = OrderDB::insert($orderParams);

        foreach ($cartItems["items"] as $item) {
            $orderItemParams['order_id'] = $orderId;
            $orderItemParams['item_id']  = $item['item_id'];
            $orderItemParams['quantity'] = $item['qty'];

            OrderItemDB::insert($orderItemParams);
        }

        $orderSuccess['id']   = $orderId;
        $orderSuccess['date'] = $currDate;

        unset($_SESSION["cart"]);
        echo ViewHelper::render("view/orders/order-confirmation.php", [
            "orderSuccess" => $orderSuccess
        ]);
    }

}
