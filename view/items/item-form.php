<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>WebShop</title>

<h1><?= $title ?></h1>

<p>[
    <a href="<?= BASE_URL . "items" ?>">All items</a> |
    <a href="<?= BASE_URL . "items/add" ?>">Add new</a>
    ]</p>

<?= $form ?>

<?=
isset($deleteForm) ? $deleteForm : "" ?>
