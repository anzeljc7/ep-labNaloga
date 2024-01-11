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
                <h1>Shopping cart (<?= isset($cartItems["items"]) ? sizeof($cartItems["items"]) : 0 ?>)</h1>
                <a class="btn btn-outline-secondary" href="<?= BASE_URL . "shop" ?>">Back</a>
            </div>
            <?php
            if (isset($cartItems["items"])) {
                ?>
                <div class = "cart" >
                    <?php
                    $skupna_cena = 0;
                    foreach ($cartItems["items"] as $item):
                        ?>  
                        <form class="d-flex justify-content-between align-items-center col-5 mb-3 mx-auto" action="<?= BASE_URL . "shop/updateCart" ?>" method="post">
                            <input  type="hidden" name="id" value="<?= $item["item_id"] ?>" />
                            <input class = "form-control" type="number" name="qty" min="0" value= <?= $item["qty"] ?> />
                            <div class="d-flex justify-content-between align-items-center ms-5">
                                <p class="m-0 ms-2" style="white-space: nowrap;"><?= $item["item_name"] ?></p>
                                <button type="submit" class = "btn btn-primary btn-sm ms-2">Update</button>
                            </div>
                        </form>
                        <?php
                    endforeach;
                    ?>  

                    <p class="text-center"><b>Total: </b><span class="badge bg-success rounded-pill p-2 ms-2"><?= number_format($cartItems["total"], 2) ?> EUR</span><br/></br>

                    <div class="d-flex justify-content-center">
                        <form action="<?= BASE_URL . "shop/deleteCart" ?>" method="post">
                            <button class = "btn btn-danger ms-2" type="submit">Empty shopping cart</button>
                        </form>
                        <form action="<?= BASE_URL . "shop/previewOrder" ?>" method="post">
                            <button class = "btn btn-success ms-2" type="submit">Submit order</button>
                        </form>
                    </div>
                    </p>
                </div>

            <?php } else {
                ?>
                <p class="text-center"> Your shopping cart is empty </p>
            <?php } ?>
        </div>
    </body>
</html>
