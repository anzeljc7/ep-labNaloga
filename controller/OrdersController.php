<?php

require_once("model/OrderDB.php");
require_once("model/UserDB.php");
require_once("model/PostNumDB.php");
require_once("ViewHelper.php");
require_once("forms/ItemsForm.php");

class OrdersController {

    public static function index() {
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $data = filter_input_array(INPUT_GET, $rules);
        if ($data !== null && isset($data["id"])) {
            $inputParameters['order_id'] = $data["id"];
            $order                       = OrderDB::get($inputParameters);
            $orderItems                  = OrderItemDB::getByOrderId($inputParameters);

            foreach ($orderItems as $index => $orderItem) {
                $item                            = ItemDB::get(['item_id' => $orderItem['item_id']]);
                $orderItems[$index]['price']     = $item['price'];
                $orderItems[$index]['item_name'] = $item['item_name'];
            }

            $orderUser        = UserDB::get(['user_id' => $order['user_id']]);
            $allowedKeys = ['user_id', 'name', 'surname', 'email'];
            $user = array_intersect_key($orderUser, array_flip($allowedKeys));

            $address['street']       = $orderUser['street'];
            $address['house_number'] = $orderUser['house_number'];
            $address['postal_code']  = $orderUser['postal_code'];
            $post                    = PostNumDB::get(['postal_code' => $address['postal_code']]);
            $address['city']         = $post['city'];
            
            $currUser = AuthDB::getCurrentUser();
            
            echo ViewHelper::render("view/orders/order-detail.php", [
                "order" => $order,
                "user" => $user,
                "orderItems" => $orderItems,
                "address"=>$address,
            ]);
        }
    }

    public static function ordersMy() {
        $currUser                   = AuthDB::getCurrentUser();

        echo ViewHelper::render("view/orders/order-list.php", [
            "orders" => OrderDB::getByUser(['user_id' => $currUser['user_id']]),
            "owner" => true,
            "title" => "Your orders"
        ]);
    }

    public static function ordersPending() {
        $inputParams["status_id"] = ORDER_PENDING;
        $orders                   = OrderDB::getByStatus($inputParams);
        echo ViewHelper::render("view/orders/order-list.php", [
            "orders" => $orders,
            "title" => "Pending orders",
            "owner" => false,
        ]);
    }

    public static function ordersConfirmed() {
        $inputParams["status_id"] = ORDER_CONFIRMED;
        $orders                   = OrderDB::getByStatus($inputParams);
        echo ViewHelper::render("view/orders/order-list.php", [
            "orders" => $orders,
            "title" => "Confirmed orders",
            "owner" => false,
        ]);
    }

    public static function ordersCanceled() {
        $inputParams["status_id"] = ORDER_CANCELED;
        $orders                   = OrderDB::getByStatus($inputParams);
        echo ViewHelper::render("view/orders/order-list.php", [
            "orders" => $orders,
            "title" => "Canceled orders",
            "owner" => false,
        ]);
    }

    public static function ordersRemoved() {
        $inputParams["status_id"] = ORDER_REMOVED;
        $orders                   = OrderDB::getByStatus($inputParams);
        echo ViewHelper::render("view/orders/order-list.php", [
            "orders" => $orders,
            "title" => "Removed orders",
            "owner" => false,
        ]);
    }

    public static function ordersUpdate() {
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ],
            "status" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $data = filter_input_array(INPUT_POST, $rules);
        if ($data !== null && isset($data["status"])) {
            $inputParams['status_id'] = $data["status"];
            $inputParams['order_id']  = $data["id"];

            OrderDB::update($inputParams);
        }
        ViewHelper::redirect(BASE_URL . "ordersPending");
    }
}
