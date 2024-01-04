<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>WebShop</title>

<h1>All items</h1>

<p>[
    <a href="<?= BASE_URL . "items" ?>">All items</a> |
    <a href="<?= BASE_URL . "items/add" ?>">Add new</a>
    ]</p>

<ul>

    <?php foreach ($items as $item): ?>
        <li>
            <a href="<?= BASE_URL . "items?id=" . $item["item_id"] ?>"><?= $item["item_name"] ?> : </a> 
            <span>(<?= $item["price"] ?> EUR)</span>
            <?php if ($item["active"]) { ?>
                <form action="<?= BASE_URL . "items/deactivate" ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $item["item_id"]; ?>">
                    <button type="submit">Deactivate</button>
                </form>
            <?php } else { ?>
                <form action="<?= BASE_URL . "items/activate" ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $item["item_id"]; ?>">
                    <button type="submit">Activate</button>
                </form>
            <?php } ?>

        </li>
    <?php endforeach; ?>

</ul>
