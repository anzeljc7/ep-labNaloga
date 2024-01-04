<?php

// enables sessions for the entire app
session_start();

require_once("controller/ItemsController.php");
require_once("controller/ShoppingController.php");

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
    "shop/ConfirmOrder" => function () {
        ShoppingController::confirmOrder();
    },
    "" => function () {
        ViewHelper::redirect(BASE_URL . "shop");
    },
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
