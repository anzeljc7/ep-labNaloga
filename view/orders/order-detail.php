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
    <body>
        <div class="container mx-auto m-4">
            <div class="d-flex justify-content-between align-items-center mb-4"> 
                <h1>Details of order <b><?= $order["order_id"] ?></b></h1>
                
                                    

                <a href="<?= BASE_URL . $currUser['user_id'] === $user['user_id'] ? "ordersPending" : "ordersMy"  ?>" class="btn btn-outline-secondary ms-2">Back</a>
            </div>


            <p>
                <strong>Date:</strong> <?= $order['order_date'] ?><br>
            </p>

            <p>
                <strong>Order for:</strong><br>
                
                <?= $user['name'] ?>  <?= $user['surname'] ?> <?= $currUser['user_id'] ?> <?= $user['user_id'] ?><br>
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
                    <?php foreach ($orderItems as $item): ?>
                        <tr>
                            <td><a href="<?= BASE_URL . "items?id=" . $item["item_id"] ?>"><?= $item["item_name"] ?></a></td>
                            <td><?= $item["quantity"] ?></td>
                            <td><?= $item['price'] ?> EUR</td>
                            <td><?= $item['price'] * $item['quantity'] ?> EUR</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: center;"><strong>Total</strong></td>
                        <td><span class="badge bg-success rounded-pill p-2"><?= $order['total'] ?> EUR</span></td>
                    </tr>
                </tfoot>
            </table>

        </div>

    </body>
</html>

