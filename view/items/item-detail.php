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
                <h1>Details of: <?= $item["item_name"] ?></h1>
                <div class="d-flex justify-content-center">
                    <a href="<?= BASE_URL . ($showEdit == true ? "items" : "shop") ?>" class="btn btn-outline-secondary ms-2">Back</a>
                    <?php if ($showEdit): ?>
                        <a href="<?= BASE_URL . "items/edit?id=" . $item["item_id"] ?>" class="btn btn-outline-primary ms-2">Edit</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div id="imageCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner bg-dark d-flex align-items-center"  style=" height: 400px; overflow: hidden; border-radius: 8px; text-align: center;">
                            <?php
                            $firstImage = true; // Flag to determine the first image
                            foreach ($uploadedImages as $image) {
                                ?>
                                <div class="carousel-item <?= $firstImage ? 'active' : '' ?>">
                                    <img src="<?= IMAGES_URL . $image['image_path'] ?>" class="d-block w-100 h-100" style="object-fit: cover;" alt="Image">
                                </div>
                                <?php
                                $firstImage = false;
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>

                <div class="col-md-8">
                    <ul class="list-group">
                        <li class="list-group-item">Description: <i><?= $item["description"] ?></i></li>
                        <li class="list-group-item">Price: <b><?= $item["price"] ?> EUR</b></li>
                        <li class="list-group-item"><?php echo $item['active'] ? '<span class="badge bg-success rounded-pill">Active</span>' : '<span class="badge bg-danger rounded-pill">Unactive</span>'; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>