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
                <h1>All items (<?= isset($items) ? sizeof($items) : 0 ?>)</h1>
                <a class="btn btn-outline-primary" href="<?= BASE_URL . "items/add" ?>">Add new</a>
            </div>

            <table class="rounded table mx-auto text-center bg-white">
                <thead>
                    <tr>
                        <th scope="col">Item ID</th>
                        <th scope="col">Item Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= $item["item_id"] ?></td>
                            <td><a href="<?= BASE_URL . "items?id=" . $item["item_id"] ?>"><?= $item["item_name"] ?></a></td>
                            <td><?php echo $item['active'] ? '<span class="badge bg-success rounded-pill">Active</span>' : '<span class="badge bg-danger rounded-pill">Unactive</span>'; ?></td>
                            <td>
                                <?php if ($item["active"]) { ?>
                                    <form action="<?= BASE_URL . "items/deactivate" ?>" method="post">
                                        <input type="hidden" name="id" value="<?= $item["item_id"]; ?>">
                                        <button type="submit" class="btn btn-danger">Deactivate</button>
                                    </form>
                                <?php } else { ?>
                                    <form action="<?= BASE_URL . "items/activate" ?>" method="post">
                                        <input type="hidden" name="id" value="<?= $item["item_id"]; ?>">
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