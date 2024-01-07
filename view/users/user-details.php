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
    <a href="<?= BASE_URL . $type  ?>">Back</a>
    ]</p>

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
    
<?php
if(isset($error)){
?>
<p style="color:red"><?=$error?></p>
<?php
}
?>

