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
require_once("AuthHelper.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

// ROUTER: defines mapping between URLS and controllers
$urls      = [
    "login" => function () {
        //AuthHelper::checkForCertificate("test");
        AuthController::login();
    },
    "register" => function () {
        AuthController::register();
    },
    "logout" => function () {
        if (AuthHelper::checkUserRole([TYPE_ADMIN, TYPE_CUSTOMER, TYPE_SELLER])) {
            AuthController::logout();
        }
    },
    "items" => function () {

        if (AuthHelper::checkUserRole([TYPE_SELLER, TYPE_CUSTOMER])) {
            //AuthHelper::checkForCertificate("test");
            ItemsController::index();
        }
    },
    "items/uploadImages" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            ItemsController::uploadImages();
        }
    },
    "items/editImages" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            ItemsController::editImages();
        }
    },
    "items/add" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            ItemsController::add();
        }
    },
    "items/edit" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            ItemsController::edit();
        }
    },
    "items/activate" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            ItemsController::activate();
        }
    },
    "items/deactivate" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            ItemsController::deactivate();
        }
    },
    "shop" => function () {
        ShoppingController::index();
    },
    "shop/cart" => function () {
        ShoppingController::cart();
    },
    "shop/addToCart" => function () {
        if (AuthHelper::checkUserRole([TYPE_CUSTOMER])) {
            ShoppingController::addToCart();
        }
    },
    "shop/deleteCart" => function () {
        if (AuthHelper::checkUserRole([TYPE_CUSTOMER])) {
            ShoppingController::deleteFromCart();
        }
    },
    "shop/updateCart" => function () {
        if (AuthHelper::checkUserRole([TYPE_CUSTOMER])) {
            ShoppingController::updateCart();
        }
    },
    "shop/previewOrder" => function () {
        if (AuthHelper::checkUserRole([TYPE_CUSTOMER])) {
            ShoppingController::orderPreview();
        }
    },
    "shop/confirmOrder" => function () {
        if (AuthHelper::checkUserRole([TYPE_CUSTOMER])) {
            ShoppingController::orderConfirm();
        }
    },
    "orders" => function () {
        if (AuthHelper::checkUserRole([TYPE_CUSTOMER, TYPE_SELLER])) {
            OrdersController::index();
        }
    },
    "ordersMy" => function () {
        if (AuthHelper::checkUserRole([TYPE_CUSTOMER])) {
            OrdersController::ordersMy();
        }
    },
    "ordersPending" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            OrdersController::ordersPending();
        }
    },
    "ordersConfirmed" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            OrdersController::ordersConfirmed();
        }
    },
    "ordersCanceled" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            OrdersController::ordersCanceled();
        }
    },
    "ordersRemoved" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            OrdersController::ordersRemoved();
        }
    },
    "orders/update" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            OrdersController::ordersUpdate();
        }
    },
    "myAccount" => function () {
        if (AuthHelper::checkUserRole([TYPE_ADMIN, TYPE_CUSTOMER, TYPE_SELLER])) {
            UsersController::myAccount();
        }
    },
    "sellers" => function () {
        if (AuthHelper::checkUserRole([TYPE_ADMIN])) {
            SellersController::index();
        }
    },
    "sellers/edit" => function () {
        if (AuthHelper::checkUserRole([TYPE_ADMIN])) {
            SellersController::editSeller();
        }
    },
    "sellers/add" => function () {
        if (AuthHelper::checkUserRole([TYPE_ADMIN])) {
            SellersController::addSeller();
        }
    },
    "sellers/activate" => function () {
        if (AuthHelper::checkUserRole([TYPE_ADMIN])) {
            SellersController::activate();
        }
    },
    "sellers/deactivate" => function () {
        if (AuthHelper::checkUserRole([TYPE_ADMIN])) {
            SellersController::deactivate();
        }
    },
    "customers" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            CustomersController::index();
        }
    },
    "customers/edit" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            CustomersController::editCustomer();
        }
    },
    "customers/add" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            CustomersController::addCustomer();
        }
    },
    "customers/activate" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            CustomersController::activate();
        }
    },
    "customers/deactivate" => function () {
        if (AuthHelper::checkUserRole([TYPE_SELLER])) {
            CustomersController::deactivate();
        }
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
