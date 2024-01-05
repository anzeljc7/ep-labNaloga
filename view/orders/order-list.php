<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>WebShop</title>

<h1><?=$title?></h1>

<?php if(!$owner){ ?>
<p>[
    <a href="<?= BASE_URL . "ordersPending" ?>">Pending</a> |
    <a href="<?= BASE_URL . "ordersConfirmed" ?>">Confirmed</a>|
    <a href="<?= BASE_URL . "ordersCanceled" ?>">Canceled</a>|
    <a href="<?= BASE_URL . "ordersRemoved" ?>">Removed</a>

    ]</p>
<ul>
<?php } ?>
    
    <?php foreach ($orders as $order): ?>
        <li>
            <?php
            echo ViewHelper::render("view/orders/order.php", [
                "order" => $order,
                "owner" => $owner
            ])
            ?>
        </li>
    <?php endforeach; ?>

</ul>
