<?php

// enables sessions for the entire app
session_start();

define('ORDER_PENDING', 1000);
define('ORDER_CONFIRMED', 2000);
define('ORDER_CANCELED', 3000);
define('ORDER_REMOVED', 4000);

define('TYPE_ADMIN', 1000);
define('TYPE_SELLER', 2000);
define('TYPE_CUSTOMER', 3000);
define('TYPE_PENDING', 4000);

require_once("controller/AuthController.php");
require_once("controller/ItemsController.php");
require_once("controller/ShoppingController.php");
require_once("controller/OrdersController.php");
require_once("controller/UsersController.php");
require_once("controller/SellersController.php");
require_once("controller/CustomersController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

// ROUTER: defines mapping between URLS and controllers
$urls      = [
    "login" => function () {
        AuthController::login();
    },
    "register" => function () {
        AuthController::register();
    },
    "logout" => function () {
        AuthController::logout();
    },
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
    "myAccount" => function () {
        UsersController::myAccount();
    },
    "sellers" => function () {
        SellersController::index();
    },
    "sellers/edit" => function () {
        SellersController::editSeller();
    },
    "sellers/add" => function () {
        SellersController::addSeller();
    },
    "sellers/activate" => function () {
        SellersController::activate();
    },
    "sellers/deactivate" => function () {
        SellersController::deactivate();
    },
    "customers" => function () {
        CustomersController::index();
    },
    "customers/edit" => function () {
        CustomersController::editCustomer();
    },
    "customers/add" => function () {
        CustomersController::addCustomer();
    },
    "customers/activate" => function () {
        CustomersController::activate();
    },
    "customers/deactivate" => function () {
        CustomersController::deactivate();
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
