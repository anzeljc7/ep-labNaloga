<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>WebShop</title>

<?php
echo ViewHelper::render("view/navbar/navbar.php", [
    "currUser" => $currUser
])
?>

<h1>Details of: <?= $item["item_name"] ?></h1>

<p>[
    <a href="<?= BASE_URL . "items" ?>">All items</a> |
    <a href="<?= BASE_URL . "items/add" ?>">Add new</a>
    ]</p>

<ul>
    <li>Description: <i><?= $item["description"] ?></i></li>
    <li>Price: <b><?= $item["price"] ?> EUR</b></li>
    <li>Active: <b><?= $item["active"] ?></b></li>
</ul>

<p>[ <a href="<?= BASE_URL . "items/edit?id=" . $item["item_id"] ?>">Edit</a>

