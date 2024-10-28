<?php 
    require_once 'core/dbConfig.php';
    require_once 'core/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete order</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php $getOneOrder_OfCustomer = getOneOrder_OfCustomer($pdo, $_GET['order_id']); ?>

        <h1>Are you sure you want to delete this order?</h1>

        <div class="container" style="border-style: solid; height: 400px;">
            <h2>Order: <?= $getOneOrder_OfCustomer['order_Name'] ?></h2>
            <h2>Quantity: <?= $getOneOrder_OfCustomer['order_Quantity'] ?></h2>
            <h2>Price: <?= $getOneOrder_OfCustomer['order_Price'] ?></h2>
            <h2>Customer: <?= $getOneOrder_OfCustomer['customer'] ?></h2>
            <h2>Date Added: <?= $getOneOrder_OfCustomer['date_added'] ?></h2>

            <div class="deleteBtn" style="float: right; margin-right: 10px;">
                <form action="core/handleForms.php?order_id=<?= $_GET['order_id']; ?>&customer_id=<?= $_GET['customer_id']; ?>" method="POST">
                    <input type="submit" name="del_Order_Btn" value="Delete">
                </form>			
            </div>	
        </div>
</body>
</html>
