<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>WebShop</title>
        <link rel="stylesheet" href="<?= CSS_URL . "bootstrap.min.css" ?>">
        <link rel="stylesheet" href="<?= CSS_URL . "custom.css" ?>">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    </head>
    <body>
        <?php
        echo ViewHelper::render("view/navbar/navbar.php", [
            "currUser" => $currUser,
            "cartCount" => $cartCount
        ])
        ?>

        <div class="container mx-auto m-4">

            <div class="d-flex justify-content-between align-items-center mb-4"> 
                <h1>All items (<?= isset($items) ? sizeof($items) : 0 ?>)</h1>
                <a class="btn btn-outline-secondary" href="<?= BASE_URL . "shop" ?>">Back</a>
            </div>
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
                    <form action="<?= BASE_URL . "shop/previewOrder" ?>" method="post">
                        <button type="submit">Submit order</button>
                    </form>
                    </p>
                </div>

            <?php } else {
                ?>
                <p class="text-center"> Your shopping cart is empty </p>
            <?php } ?>
        </div>
    </body>
</html>
