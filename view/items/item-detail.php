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

        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4"> 
                <h1>Details of: <?= $item["item_name"] ?></h1>
                <div class="d-flex justify-content-center"> 
                    <a href="<?= BASE_URL . "items" ?>" class="btn btn-outline-secondary ms-2">Back</a>
                    <a href="<?= BASE_URL . "items/edit?id=" . $item["item_id"] ?>" class="btn btn-outline-primary ms-2">Edit</a>
                </div>
            </div>

            <ul class="list-group">
                <li class="list-group-item">Description: <i><?= $item["description"] ?></i></li>
                <li class="list-group-item">Price: <b><?= $item["price"] ?> EUR</b></li>
                <li class="list-group-item">Active: <b><?= $item["active"] ?></b></li>
            </ul>
        </div>

    </body>
</html>