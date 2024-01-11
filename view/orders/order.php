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

    <tr>
        <td><a href="<?= BASE_URL . "orders?id=" . $order["order_id"] ?>">Order <?= $order["order_id"] ?></a></td>
        <td><?= $order["order_date"] ?></td>
        <?php if ($order['status_id'] == ORDER_PENDING): ?>
            <td><span class="badge bg-primary rounded-pill">Pending</span></td>
            <td></td>
        <?php elseif ($order['status_id'] == ORDER_CONFIRMED): ?>
            <td><span class="badge bg-success rounded-pill">Confirmed</span></td>
            <td></td>
        <?php elseif ($order['status_id'] == ORDER_CANCELED): ?>
            <td><span class="badge bg-danger rounded-pill">Canceled</span></td>
            <td></td>
        <?php elseif ($order['status_id'] == ORDER_REMOVED): ?>
            <td><span class="badge bg-secondary rounded-pill">Removed</span></td>
            <td></td>
        <?php endif; ?>

        <?php if (!$owner): ?>
            <?php if ($order['status_id'] == ORDER_PENDING): ?>
                <td>
                    <div class="d-flex justify-content-center align-items-center"> 
                        <form action="<?= BASE_URL . "orders/update" ?>" method="post">
                            <input type="hidden" name="id" value="<?= $order["order_id"] ?>">
                            <input type="hidden" name="status" value="<?= ORDER_CONFIRMED ?>">
                            <button class="btn btn-success ms-1" type="submit">Confirm</button>
                        </form>
                        <form action="<?= BASE_URL . "orders/update" ?>" method="post">
                            <input type="hidden" name="id" value="<?= $order["order_id"] ?>">
                            <input type="hidden" name="status" value="<?= ORDER_CANCELED ?>">
                            <button class="btn btn-danger ms-1" type="submit">Cancel</button>
                        </form>
                    </div>
                </td>
            <?php elseif ($order['status_id'] == ORDER_CONFIRMED): ?>
                <td>
                    <form action="<?= BASE_URL . "orders/update" ?>" method="post">
                        <input type="hidden" name="id" value="<?= $order["order_id"] ?>">
                        <input type="hidden" name="status" value="<?= ORDER_REMOVED ?>">
                        <button class="btn btn-secondary" type="submit">Remove</button>
                    </form>
                </td>
            <?php endif; ?>
        <?php endif; ?>
    </tr>

</body>
</html>
