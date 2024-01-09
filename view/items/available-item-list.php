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
            "currUser" => $currUser
        ])
        ?>

        <?php
        echo ViewHelper::render("view/items/shopping-cart.php", [
            "cartItems" => $cartItems
        ])
        ?>

        <div class="container mx-auto m-4">
            <h1 class="mt-4 mb-4">Available items in store</h1>

            <div class="row">

                <?php foreach ($items as $item): ?>
                    <div class="col-md-3 mb-3">
                        <div class="card rounded bg-primary">
                            <img src="https://rukminim2.flixcart.com/image/850/1000/xif0q/trouser/e/s/z/30-tu1-vebnor-original-imagmy6hhhz62qzn.jpeg?q=90" class="object-fit-cover border rounded">

                            <div class="card-body">
                                <!-- Item Name -->
                                <h5 class="card-title"><?= $item["item_name"] ?></h5>
                                <!-- Price -->
                                <p class="card-text"><?= $item["price"] ?> EUR</p>
                                <form action="<?= BASE_URL . "shop/addToCart" ?>" method="post">
                                    <input type="hidden" name="id" value="<?= $item["item_id"]; ?>">
                                    <button type="submit" class="btn btn-primary btn-sm">Add to cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </body>
</html>