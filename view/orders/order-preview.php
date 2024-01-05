<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>WebShop</title>
        <style>
        </style>
    </head>
    <body>
        <h1>Order preview</h1>

        <p>
            <strong>Date:</strong> <?= $cartItems['date'] ?><br>
        </p>

        <p>
            <strong>Order for:</strong><br>
            <?= $currentUser['name'] ?>  <?= $currentUser['surname'] ?><br>
            <?= $address['street'] ?> <?= $address['house_number'] ?> <?= $address['city'] ?> <?= $address['postal_code'] ?><br>
            <a href="<?= BASE_URL . "account" ?>">Update your shopping address</a>
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