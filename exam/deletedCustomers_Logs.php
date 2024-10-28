<?php 
    require_once 'core/dbConfig.php';
    require_once 'core/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Deleted Customers Log</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <a href="index.php">Return to home</a>
        
        <?php $getAll_Customer_DeleteLogs = getAll_Customer_DeleteLogs($pdo); ?>
        <?php foreach ($getAll_Customer_DeleteLogs as $row) { ?>
            <div class="big_div" style="position: relative; border-style: solid; width: 50%; height: 150px; margin-top: 20px;">
                <h3>Customer ID: <?= $row['customer_id']; ?></h3>
                <h3>Deleted By: <?= $row['deleted_by']; ?></h3>
                <h3>Time Deleted: <?= $row['time_deleted']; ?></h3>
            </div>
        <?php } ?>
    </body>
</html>