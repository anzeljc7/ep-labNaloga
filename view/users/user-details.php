<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>WebShop</title><head>
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

    <div class="container mx-auto m-4 col-5">
        <div class="d-flex justify-content-between align-items-center mb-4"> 
            <h1><?= $title ?></h1>
            <a class="btn btn-outline-secondary" href="<?= BASE_URL . $type ?>">Back</a>
        </div>

        <?php if ($details) { ?>
            <p>Tip računa: <?= $user['type_id'] ?></p>
            <p>Status računa: <?= $user['active'] ?></p>
            <?php if ($user["active"]) { ?>
                <form action="<?= BASE_URL . $type . "/deactivate" ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $user["user_id"]; ?>">
                    <button type="submit">Deactivate</button>
                </form>
            <?php } else { ?>
                <form action="<?= BASE_URL . $type . "/activate" ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $user["user_id"]; ?>">
                    <button type="submit">Activate</button>
                </form>
            <?php } ?>
        <?php } ?>

        <?= $form ?>

        <?php
        if (isset($error)) {
            ?>
            <p style="color:red"><?= $error ?></p>
            <?php
        }
        ?>
    </div>
</body>
</html>