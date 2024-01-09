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

        <nav class="navbar navbar-expand-lg navbar-light bg-light ps-3 px-4 flex justify-content-between mb-4">
            <a class="navbar-brand " href="<?= BASE_URL ?>">WebShop</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav ml-auto">

                    <?php if (!isset($currUser)) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL . "login" ?>">Login</a>
                        </li>
                    <?php } else { ?>

                        <?php if ($currUser['type_id'] == TYPE_CUSTOMER) { ?>

                            <?php if ($cartCount): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= BASE_URL . "shop/cart" ?>">Cart  <span class="badge alert-primary"><?= $cartCount ?></span></a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL . "ordersMy" ?>">My Orders</a>
                            </li>
                        <?php } else if ($currUser['type_id'] == TYPE_SELLER) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL . "items" ?>">Items</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL . "customers" ?>">Customers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL . "ordersPending" ?>">Orders</a>
                            </li>
                        <?php } else if ($currUser['type_id'] == TYPE_ADMIN) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL . "sellers" ?>">Sellers</a>
                            </li>
                        <?php } ?>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL . "myAccount" ?>">My Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL . "logout" ?>">Logout</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>

    </body>
</html>
