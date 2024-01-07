<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>WebShop</title>

<?php
echo ViewHelper::render("view/navbar/navbar.php", [
    "currUser" => $currUser
])
?>

<h1><?= $title ?></h1>

<p>[
    <a href="<?= BASE_URL . $type . "/edit" ?>">All <?=$type?></a> |
    <a href="<?= BASE_URL . $type . "/add" ?>">Add new</a>
    ]</p>

<ul>

    <?php foreach ($users as $user): ?>
        <li>
            <a href="<?= BASE_URL . $type ."/edit/?id=" . $user["user_id"] ?>"><?= $user["name"] ?> <?= $user["surname"] ?> : </a> 
            <span>(<?= $user["email"] ?>)</span>
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

        </li>
    <?php endforeach; ?>

</ul>
