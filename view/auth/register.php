<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>WebShop</title>

<h1><?= $title ?></h1>

<p>[
    <a href="<?= BASE_URL . "login" ?>">Login</a>
    ]</p>

<?= $form?>

<?php
if(isset($error)){
?>
<p style="color:red"><?=$error?></p>
<?php
}
?>

