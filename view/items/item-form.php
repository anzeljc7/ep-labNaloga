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

        <div class="container mx-auto m-4 col-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><?= $title ?></h1>
                <div class="d-flex justify-content-center">
                    <a class="btn btn-outline-secondary ms-2" href="<?= BASE_URL . "items" ?>">Back</a>

                    <?php if ($type === 'edit'): ?>
                        <a class="btn btn-outline-primary ms-2" href="<?= BASE_URL . "items/editImages/?id=" . $itemId ?>" ?>Upload images</a>
                    <?php endif; ?>
                </div>
            </div>
            <?= $form ?>

        </div>
    </body>
</html>
