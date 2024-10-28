<?php 
    require_once 'core/dbConfig.php';
    require_once 'core/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Orders</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <a href="index.php">Return to home</a>
        <h1>Add New Order</h1>
        
        <form action="core/handleForms.php?customer_id=<?= $_GET['customer_id']; ?>" method="POST">
            <p>
                <label for="order_Name">Product</label> 
                <input type="text" name="order_Name">
            </p>
            <p>
                <label for="order_Quantity">Quantity</label> 
                <input type="text" name="order_Quantity">
            </p>
            <p>
                <label for="order_Price">Price</label> 
                <input type="text" name="order_Price">
                
                <input type="submit" name="add_Order_Btn">
            </p>
        </form>
        
        <p><a href="deletedOrders_Logs.php?customer_id=<?= $_GET['customer_id']; ?>">Deleted Orders</a></p>

        <table style="width:100%; margin-top: 50px;">
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Customer</th>
                <th>Added By</th>
                <th>Date Added</th>
                <th>Action</th>
                <th>Updated By</th>
                <th>Last Updated</th>
            </tr>
            <?php $getAllOrders_OfCustomer = getAllOrders_OfCustomer($pdo, $_GET['customer_id']); ?>
            <?php foreach ($getAllOrders_OfCustomer as $row) { ?>
                <tr>
                    <td><?= $row['order_id']; ?></td>	  	
                    <td><?= $row['order_Name']; ?></td>	  	
                    <td><?= $row['order_Quantity']; ?></td>	  	
                    <td><?= $row['order_Price']; ?></td>
                    <td><?= $row['customer']; ?></td>
                    <td><?= $row['added_by']; ?></td>
                    <td><?= $row['date_added']; ?></td>
                    <td>
                        <a href="edit_Order.php?order_id=<?= $row['order_id']; ?>&customer_id=<?= $_GET['customer_id']; ?>">Edit</a>

                        <a href="del_Order.php?order_id=<?= $row['order_id']; ?>&customer_id=<?= $_GET['customer_id']; ?>">Delete</a>
                    </td>
                    <?php if (isset($row['updated_by'])) { ?> <!-- if record has been updated -->
                        <td><?= $row['updated_by']; ?></td>
                        <td><?= $row['last_updated']; ?></td>
                    <?php } ?>
                </tr>
        <?php } ?>
        </table>
    </body>
</html>