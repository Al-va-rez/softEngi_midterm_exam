<?php
    require_once 'core/dbConfig.php';
    require_once 'core/functions.php';

    // if user not yet registered and/or logged in
    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customers</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1>Add a customer</h1>
        <p><a href="logout.php">Logout</a></p>

        <form action="core/handleForms.php" method="POST">
            <p>
                <label for="username">Username</label> 
                <input type="text" name="username">
            </p>
            <p>
                <label for="first_Name">First Name</label> 
                <input type="text" name="first_Name">
            </p>
            <p>
                <label for="last_Name">Last Name</label> 
                <input type="text" name="last_Name">
            </p>
            <p>
                <label for="home_address">Home Address</label> 
                <input type="text" name="home_address">
            </p>
            <p>
                <label for="contact_Num">Contact Number</label> 
                <input type="text" name="contact_Num">
            </p>

            <p>
                <input type="submit" name="add_Customer_Btn">
            </p>
        </form>

        <p><a href="deletedCustomers_Logs.php">Deleted Customer Records</a></p>
        
        <?php $getAllCustomers = getAllCustomers($pdo); ?>
        <?php foreach ($getAllCustomers as $row) { ?>
            <div class="big_div" style="position: relative; border-style: solid; width: 40%; height: 400px; margin-top: 20px;">
                <h3>Username: <?= $row['username']; ?></h3>
                <h3>FirstName: <?= $row['first_Name']; ?></h3>
                <h3>LastName: <?= $row['last_Name']; ?></h3>
                <h3>Home Address: <?= $row['home_address']; ?></h3>
                <h3>Contact Number: <?= $row['contact_Num']; ?></h3>
                <h3>Added By: <?= $row['added_by']; ?></h3>
                <h3>Date Added: <?= $row['date_added']; ?></h3>
                <?php if (isset($row['updated_by'])) { ?> <!-- if record has been updated -->
                    <h3>Updated By: <?= $row['updated_by']; ?></h3>
                    <h3>Last Updated: <?= $row['last_updated']; ?></h3>
                <?php } ?>

                <div class="small_div" style="position: absolute; margin: 0px 20px 20px 0px; right: 0; bottom: 0;">
                    <a href="view_Orders.php?customer_id=<?= $row['customer_id']; ?>">View Orders</a>
                    <a href="edit_Customer.php?customer_id=<?= $row['customer_id']; ?>">Edit</a>
                    <a href="del_Customer.php?customer_id=<?= $row['customer_id']; ?>">Delete</a>
                </div>
            </div>
        <?php } ?>
    </body>
</html>