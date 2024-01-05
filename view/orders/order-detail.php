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
        <h1>Details of order <b>'<?= $order["order_id"] ?>'</b></h1>

        <p>
            <strong>Date:</strong> <?= $order['order_date'] ?><br>
        </p>

        <p>
            <strong>Order for:</strong><br>
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
                <?php foreach ($orderItems as $item): ?>
                    <tr>
                        <td><?= $item['item_name'] ?></td>
                        <td><?= $item["quantity"] ?></td>
                        <td><?= $item['price'] ?></td>
                        <td><?= $item['price'] * $item['quantity'] ?> EUR</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                    <td><?= $order['total'] ?> EUR</td>
                </tr>
            </tfoot>
        </table>

    </body>
</html>

