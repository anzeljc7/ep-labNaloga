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
            
        <div class="container mx-auto m-4">
        <?php if (!$owner) { ?>
            <div class="d-flex justify-content-between align-items-center mb-4"> 
                <h1><?= $title ?></h1>
                <div class="d-flex justify-content-center"> 
                    <a class="btn btn-outline-primary ms-1" href="<?= BASE_URL . "ordersPending" ?>">Pending</a>
                    <a class="btn btn-outline-success ms-1" href="<?= BASE_URL . "ordersConfirmed" ?>">Confirmed</a>
                    <a class="btn btn-outline-danger ms-1" href="<?= BASE_URL . "ordersCanceled" ?>">Canceled</a>
                    <a class="btn btn-outline-secondary ms-1" href="<?= BASE_URL . "ordersRemoved" ?>">Removed</a>
                </div>
            </div>
            <?php } ?>
            
            <table class="rounded table mx-auto text-center bg-white">
                    <thead>
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php foreach ($orders as $order): ?>
                    <?php
                    echo ViewHelper::render("view/orders/order.php", [
                        "order" => $order,
                        "owner" => $owner,
                    ])
                    ?>
            <?php endforeach; ?>

        </tbody>
                </table>
        </div>
    </body>
</html>