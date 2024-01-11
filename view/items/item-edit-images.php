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
            <div class="mt-3">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Uploaded Images</h1>

                    <a href="<?= BASE_URL . "items/edit?id=" . $itemId ?>" class="btn btn-outline-secondary ms-2">Back</a>
                </div>
                <div class="image-container d-flex justify-content-between align-items-center mb-4">
                    <?php
                    foreach ($uploadedFiles as $file) {
                        ?>
                        <div style=" height: 150px; width:150px; overflow: hidden; border-radius: 8px">
                            <img src="<?= IMAGES_URL . $file['image_path'] ?>" class="d-block w-100 h-100" style="object-fit: cover;">
                        </div>
                    <?php } ?>
                </div>
            </div>

            <form action = "<?= BASE_URL . "items/uploadImages/?id=" . $itemId ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="images">Select Images</label>
                    <input type="file" name="images[]" id="images" multiple class="form-control mb-3">
                </div>
                <button type="submit" class="btn btn-primary">Upload Images</button>
            </form>


        </div>
    </body>