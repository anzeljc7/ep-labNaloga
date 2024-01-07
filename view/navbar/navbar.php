<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>WebShop</title>


<?php if (!isset($currUser)) { ?>
    <a href="<?= BASE_URL . "login" ?>">Login</a>
    <?php
} else {
    if ($currUser['type_id'] == TYPE_CUSTOMER) {
        ?>
        <a href="<?= BASE_URL . "orders" ?>">My orders</a>
        <a href="<?= BASE_URL . "shop" ?>">Shop</a>
    <?php } else if ($currUser['type_id'] == TYPE_SELLER) { ?>
        <a href="<?= BASE_URL . "items" ?>">Items</a>
        <a href="<?= BASE_URL . "customers" ?>">Customers</a>
        <a href="<?= BASE_URL . "ordersPending" ?>">Orders</a>
    <?php } else if ($currUser['type_id'] == TYPE_ADMIN) { ?>
        <a href="<?= BASE_URL . "sellers" ?>">Sellers</a>
    <?php } ?>
    <a href="<?= BASE_URL . "myAccount" ?>"> My account</a>
    <a href="<?= BASE_URL . "logout" ?>">Logout</a>
<?php } ?>




