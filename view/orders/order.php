<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>WebShop</title>

<?php
echo ViewHelper::render("view/navbar/navbar.php", [
    "currUser" => $currUser
])
?>

<?php if ($order['status_id'] == ORDER_PENDING) { ?>
    <b style="color:yellow"> PENDING ORDER <b>
<?php } elseif ($order['status_id'] == ORDER_CONFIRMED) { ?>
    <b style="color:greenyellow"> CONFIRMED ORDER <b>
<?php } elseif ($order['status_id'] == ORDER_CANCELED) { ?>
    <b style="color:red"> CANCELED ORDER <b>
<?php } elseif ($order['status_id'] == ORDER_REMOVED) { ?>
    <b style="color:orange"> REMOVED ORDER <b>
<?php }?>
            
    <a href="<?= BASE_URL . "orders?id=" . $order["order_id"] ?>">Order <?= $order["order_id"] ?> : </a> 
    <span>(<?= $order["order_date"] ?>)</span>
    <?php if (!$owner) { ?>
        <?php if ($order['status_id'] == ORDER_PENDING) { ?>
            <form action="<?= BASE_URL . "orders/update" ?>" method="post">
                <input type="hidden" name="id" value="<?=$order["order_id"]?>">
                <input type="hidden" name="status" value="<?php echo ORDER_CONFIRMED; ?>">
                <button type="submit">Confirm</button>
            </form>
            <form action="<?= BASE_URL . "orders/update" ?>" method="post">
                <input type="hidden" name="id" value="<?=$order["order_id"]?>">
                <input type="hidden" name="status" value="<?php echo ORDER_CANCELED; ?>">
                <button type="submit">Cancel</button>
            </form>
        <?php } elseif ($order['status_id'] == ORDER_CONFIRMED) { ?>
            <form action="<?= BASE_URL . "orders/update" ?>" method="post">
                <input type="hidden" name="id" value="<?=$order["order_id"]?>">
                <input type="hidden" name="status" value="<?php echo ORDER_REMOVED; ?>">
                <button type="submit">Remove</button>
            </form>
        <?php } elseif ($order['status_id'] == ORDER_CANCELED) { ?>

        <?php } elseif ($order['status_id'] == ORDER_REMOVED) { ?>

    <?php } }?>


