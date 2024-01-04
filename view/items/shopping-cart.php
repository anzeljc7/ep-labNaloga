<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "items.css" ?>">
        <meta charset="UTF-8" />
        <title>WebShop</title>
    </head>
    <body>
        <?php
        if (isset($_SESSION["cart"])) {
            ?>
            <div class = "cart" >
                <h3>Shopping card</h3>
                <p>
                    <?php
                        $skupna_cena = 0;
                        foreach ($cartItems["items"] as $item):
                            ?>  
                        <form action="<?= BASE_URL . "shop/updateCart" ?>" method="post">
                            <input type="hidden" name="id" value="<?= $item["item_id"] ?>" />
                            <p>
                                <input type="number" name="qty" min="0" value= <?= $item["qty"] ?> />
                                <?=
                                substr(strip_tags($item["item_name"]), 0, 25);
                                if (strlen($item["item_name"]) > 25) {
                                    echo "...";
                                }
                                ?>
                                <button type="submit">Update</button>
                            </p>

                        </form>
                        <?php
                    endforeach;
                    ?>  
                    <p><b>Total:</b> <?= number_format($cartItems["total"], 2) ?> EUR<br/></br>
                    <form action="<?= BASE_URL . "shop/deleteCart" ?>" method="post">
                        <button type="submit">Empty shopping cart</button>
                    </form>
                    <form action="<?= BASE_URL . "shop/confirmOrder" ?>" method="post">
                        <button type="submit">Confirm order</button>
                    </form>
            </p>
        </div>
        <?php
    }
    ?>
</body>
</html>
