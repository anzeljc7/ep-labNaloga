<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>WebShop</title>

<h1><?= $title ?></h1>

<?php if ($details) { ?>
    <p>Tip računa: <?= $user['type_id'] ?></p>
    <p>Status računa: <?= $user['active'] ?></p>
    <?php if ($user["active"]) { ?>
        <form action="<?= BASE_URL . $type . "/deactivate" ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $user["user_id"]; ?>">
            <button type="submit">Deactivate</button>
        </form>
    <?php } else { ?>
        <form action="<?= BASE_URL  . $type .  "/activate" ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $user["user_id"]; ?>">
            <button type="submit">Activate</button>
        </form>
    <?php } ?>
<?php } ?>

<?= $form ?>


