<?php

// enables sessions for the entire app
session_start();

define('ORDER_PENDING', 1000);
define('ORDER_CONFIRMED', 2000);
define('ORDER_CANCELED', 3000);
define('ORDER_REMOVED', 4000);

require_once("controller/ItemsController.php");
require_once("controller/ShoppingController.php");
require_once("controller/OrdersController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

// ROUTER: defines mapping between URLS and controllers
$urls       = [
    "items" => function () {
        ItemsController::index();
    },
    "items/add" => function () {
        ItemsController::add();
    },
    "items/edit" => function () {
        ItemsController::edit();
    },
    "items/activate" => function () {
        ItemsController::activate();
    },
    "items/deactivate" => function () {
        ItemsController::deactivate();
    },
    "shop" => function () {
        ShoppingController::index();
    },
    "shop/addToCart" => function () {
        ShoppingController::addToCart();
    },
    "shop/deleteCart" => function () {
        ShoppingController::deleteFromCart();
    },
    "shop/updateCart" => function () {
        ShoppingController::updateCart();
    },
    "shop/previewOrder" => function () {
        ShoppingController::orderPreview();
    },
    "shop/confirmOrder" => function () {
        ShoppingController::orderConfirm();
    },
    "orders" => function () {
        OrdersController::index();
    },
    "ordersPending" => function () {
        OrdersController::ordersPending();
    },
    "ordersConfirmed" => function () {
        OrdersController::ordersConfirmed();
    },
    "ordersCanceled" => function () {
        OrdersController::ordersCanceled();
    },
    "ordersRemoved" => function () {
        OrdersController::ordersRemoved();
    },
    "orders/update" => function () {
        OrdersController::ordersUpdate();
    },
    "" => function () {
        ViewHelper::redirect(BASE_URL . "shop");
    }
];

try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (InvalidArgumentException $e) {
    ViewHelper::error404();
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
} 
