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
                <h1>Order preview</h1>
                <a class="btn btn-outline-secondary" href="<?= BASE_URL . "shop/cart" ?>">Back</a>
            </div>

            <p>
                <strong>Date:</strong> <?= $cartItems['date'] ?><br>
            </p>

            <p>
                <strong>Order for:</strong><br>
                <?= $currentUser['name'] ?>  <?= $currentUser['surname'] ?><br>
                <?= $address['street'] ?> <?= $address['house_number'] ?> <?= $address['city'] ?> <?= $address['postal_code'] ?><br>
            </p>

            <table class="rounded table mx-auto text-center bg-white">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems['items'] as $item): ?>
                        <tr>
                            <td><a href="<?= BASE_URL . "items?id=" . $item["item_id"] ?>"><?= $item["item_name"] ?></a></td>
                            <td><?= $item["qty"] ?></td>
                            <td><?= $item['price'] ?> EUR</td>
                            <td><?= $item['price'] * $item['qty'] ?> EUR</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: center;"><strong>Total</strong></td>
                        <td><span class="badge bg-success rounded-pill p-2"><?= $cartItems['total'] ?> EUR</span></td>
                    </tr>
                </tfoot>
            </table>


            <div class="d-flex justify-content-start align-items-center mt-4">
                <h3 class="mt-2 ">Thank you for your order!</h3>


                <form action="<?= BASE_URL . "shop/confirmOrder" ?>" method="post">
                    <button class="btn btn-success ms-4" type="submit">Confirm</button>
                </form>
            </div>

        </div>
    </body>
</html>