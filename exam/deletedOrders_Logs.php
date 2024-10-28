<?php 
    require_once 'core/dbConfig.php';
    require_once 'core/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Deleted Orders Log</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <a href="view_Orders.php?customer_id=<?= $_GET['customer_id']; ?>">Return to Orders menu</a>
        
        <?php $getAll_Order_DeleteLogs = getAll_Order_DeleteLogs($pdo, $_GET['customer_id']); ?>
        <?php foreach ($getAll_Order_DeleteLogs as $row) { ?>
            <div class="big_div" style="position: relative; border-style: solid; width: 50%; height: 150px; margin-top: 20px;">
                <h3>Order ID: <?= $row['order_id']; ?></h3>
                <h3>Deleted By: <?= $row['deleted_by']; ?></h3>
                <h3>Time Deleted: <?= $row['time_deleted']; ?></h3>
            </div>
        <?php } ?>
    </body>
</html>