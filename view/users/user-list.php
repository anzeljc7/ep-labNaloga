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

            <div class="d-flex justify-content-between align-items-center mb-4"> 
                <h1><?= $title ?></h1>
                <a class="btn btn-outline-primary" href="<?= BASE_URL . $type . "/add" ?>">Add new</a>
            </div>

                <table class="rounded table mx-auto text-center bg-white">
                    <thead>
                        <tr>
                            <th scope="col">User ID</th>
                            <th scope="col">User Email</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                        <td><?= $user["user_id"] ?></td>
                        <td><a href="<?= BASE_URL . $type . "/edit/?id=" . $user["user_id"] ?>"><?= $user["email"] ?></a> 
                        </td>
                        <td><?= $user["active"] ? 'Active' : 'Inactive' ?></td>
                        <td>

                          
                            <?php if ($user["active"]) { ?>
                                <form action="<?= BASE_URL . $type . "/deactivate" ?>" method="post">
                                    <input type="hidden" name="id" value="<?php echo $user["user_id"]; ?>">
                                    <button type="submit" class="btn btn-danger">Deactivate</button>
                                </form>
                            <?php } else { ?>
                                <form action="<?= BASE_URL . $type . "/activate" ?>" method="post">
                                    <input type="hidden" name="id" value="<?php echo $user["user_id"]; ?>">
                                    <button type="submit" class="btn btn-success">Activate</button>
                                </form>
                            <?php } ?>

                        </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
        </div>

    </body>
</html>
