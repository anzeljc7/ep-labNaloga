<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebShop</title>
    <link rel="stylesheet" href="<?= CSS_URL . "bootstrap.min.css" ?>">
    <link rel="stylesheet" href="<?= CSS_URL . "custom.css" ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
</head>
<body>

    <div class="d-flex align-items-center justify-content-center vh-100 p-5 bg-light">
        <div class="bg-white p-4 pt-5 pb-5 rounded col-4">
            <h1 class="text-center">Register</h1>

            <div class="d-flex align-items-center justify-content-center " >
                <?= $form ?>
            </div>
            <p class="text-center">
                Have account? <a href="<?= BASE_URL . "login" ?>"> Login</a>
            </p>

            <?php if (isset($error)) : ?>
                <p style="color:red;"><?= $error ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
