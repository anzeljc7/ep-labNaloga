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
        <h1>Order preview</h1>

        <p>
            <strong>Date:</strong> <?= $cartItems['date'] ?><br>
        </p>

        <p>
            <strong>Order for:</strong><br>
            <?= $currentUser['name'] ?>  <?= $currentUser['surname'] ?><br>
            <?= $address['street'] ?> <?= $address['house_number'] ?> <?= $address['city'] ?> <?= $address['postal_code'] ?><br>
        </p>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems['items'] as $item): ?>
                    <tr>
                        <td><?= $item['description'] ?></td>
                        <td><?= $item["qty"] ?></td>
                        <td><?= $item['price'] ?></td>
                        <td><?= $item['qty'] * $item['price'] ?> EUR</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                    <td><?= $cartItems['total'] ?> EUR</td>
                </tr>
            </tfoot>
        </table>

        <p>Thank you for your business!</p>

        <a href="<?= BASE_URL . "shop" ?>">Back</a>

        <form action="<?= BASE_URL . "shop/confirmOrder" ?>" method="post">
            <button type="submit">Submit order</button>
        </form>
    </body>
</html>