<?php

require_once("model/OrderDB.php");
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
                $item                        = ItemDB::get(['item_id'=>$orderItem['item_id']]);
                $orderItems[$index]['price'] = $item['price'];
                $orderItems[$index]['item_name'] = $item['item_name'];
            }
            echo ViewHelper::render("view/orders/order-detail.php", [
                "order" => $order,
                "orderItems" => $orderItems
            ]);
        } else {
            $inputParameters['user_id'] = 1;

            echo ViewHelper::render("view/orders/order-list.php", [
                "orders" => OrderDB::getByUser($inputParameters),
                "owner" => true,
                "title" => "Your orders"
            ]);
        }
    }

    public static function ordersPending() {
        $inputParams["status_id"] = ORDER_PENDING;

        echo ViewHelper::render("view/orders/order-list.php", [
            "orders" => OrderDB::getByStatus($inputParams),
            "title" => "Pending orders",
            "owner" => false,
        ]);
    }

    public static function ordersConfirmed() {
        $inputParams["status_id"] = ORDER_CONFIRMED;

        echo ViewHelper::render("view/orders/order-list.php", [
            "orders" => OrderDB::getByStatus($inputParams),
            "title" => "Confirmed orders",
            "owner" => false,
        ]);
    }

    public static function ordersCanceled() {
        $inputParams["status_id"] = ORDER_CANCELED;

        echo ViewHelper::render("view/orders/order-list.php", [
            "orders" => OrderDB::getByStatus($inputParams),
            "title" => "Canceled orders",
            "owner" => false,
        ]);
    }

    public static function ordersRemoved() {
        $inputParams["status_id"] = ORDER_REMOVED;

        echo ViewHelper::render("view/orders/order-list.php", [
            "orders" => OrderDB::getByStatus($inputParams),
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
