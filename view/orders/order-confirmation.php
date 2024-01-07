<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>WebShop</title>

<?php
echo ViewHelper::render("view/navbar/navbar.php", [
    "currUser" => $currUser
])
?>

<h1>Order confirmed</h1>

<p>Your order with number <b>'<?= $orderSuccess['id']?>'<b> was successfully confirmed on <b><?= $orderSuccess['date']?><b></p>
[ <a href="<?= BASE_URL . "shop" ?>">Continue shopping </a>]
[ <a href="<?= BASE_URL . "orders" ?>">View your order list </a>]