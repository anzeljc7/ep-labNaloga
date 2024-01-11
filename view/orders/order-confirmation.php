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
        <div class="container mx-auto m-4 text-center">
        <h1>Order confirmed</h1>

        <p>Your order with number <b> <?= $orderSuccess['id'] ?> </b> was successfully confirmed on <b><?= $orderSuccess['date'] ?><b></p>
        <a href="<?= BASE_URL . "shop" ?>" class="btn btn-primary btn-sm ms-2">Continue shopping </a>
        <a href="<?= BASE_URL . "ordersMy"?>"  class="btn btn-secondary  btn-sm ms-2">View your order list </a>

        </div>
           
    </body>
</html>