<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>WebShop</title>

<?php
echo ViewHelper::render("view/navbar/navbar.php", [
    "currUser" => $currUser
])
?>

<h1>Available items in store</h1>

<ul>

    <?php foreach ($items as $item): ?>
        <li>
            <a href="<?= BASE_URL . "items?id=" . $item["item_id"] ?>"><?= $item["item_name"] ?> : </a> 
            <span>(<?= $item["price"] ?> EUR)</span>
            <form action="<?= BASE_URL . "shop/addToCart" ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $item["item_id"]; ?>">
                <button type="submit">Add to cart</button>
            </form>
        </li>
    <?php endforeach; ?>

</ul>

<?php
echo ViewHelper::render("view/items/shopping-cart.php", [
    "cartItems" => $cartItems
])
?>
