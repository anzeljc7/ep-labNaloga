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
            <h1 class="mt-4 mb-4">Available items in store</h1>

            <div class="row">

                <?php foreach ($items as $item): ?>
                    <div class="col-md-3 mb-2">
                        <div class="card rounded " style="width: 300px; height: 400px;">
                            <?php if (isset($item['images']) && sizeof($item['images']) > 0) { ?>
                                <img class="card-img-top img-fluid" style =  "object-fit: cover; height: 100%"  
                                     src="<?= IMAGES_URL . $item['images'][0]['image_path'] ?>" alt="Image" >
                            <?php } else { ?>
                                <img class="card-img-top img-fluid" style =  "object-fit: cover; height: 100%" 
                                     src="https://st4.depositphotos.com/14953852/24787/v/450/depositphotos_247872612-stock-illustration-no-image-available-icon-vector.jpg" alt="Image" >
                            <?php } ?>
                            <div class="card-body">
                                <!-- Item Name -->
                                <h5 class="card-title"><?= $item["item_name"] ?></h5>
                                <!-- Price -->
                                <p class="card-text"><?= $item["price"] ?> EUR</p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <form action="<?= BASE_URL . "shop/addToCart" ?>" method="post">
                                        <input type="hidden" name="id" value="<?= $item["item_id"]; ?>">
                                        <button type="submit" class="btn btn-primary btn-sm">Add to cart</button>
                                    </form>
                                    <td><a class="btn btn-secondary btn-sm" href="<?= BASE_URL . "items?id=" . $item["item_id"] ?>">Details</a></td>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>