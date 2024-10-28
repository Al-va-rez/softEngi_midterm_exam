<?php 
    require_once 'core/dbConfig.php';
    require_once 'core/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit order info</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <a href="view_Orders.php?customer_id=<?= $_GET['customer_id']; ?>">View The Orders</a>
        <h1>Edit the order!</h1>

        <?php $getOneOrder_OfCustomer = getOneOrder_OfCustomer($pdo, $_GET['order_id']); ?>

        <form action="core/handleForms.php?order_id=<?= $_GET['order_id']; ?>&customer_id=<?= $_GET['customer_id']; ?>" method="POST">
            <p>
                <label for="order_Name">Product</label> 
                <input type="text" name="order_Name" value="<?= $getOneOrder_OfCustomer['order_Name']; ?>">
            </p>
            <p>
                <label for="order_Quantity">Quantity</label> 
                <input type="text" name="order_Quantity" value="<?= $getOneOrder_OfCustomer['order_Quantity']; ?>">
            </p>
            <p>
                <label for="order_Price">Price</label> 
                <input type="text" name="order_Price" value="<?= $getOneOrder_OfCustomer['order_Price']; ?>">

                <input type="submit" name="edit_Order_Btn">
            </p>
        </form>
    </body>
</html>
