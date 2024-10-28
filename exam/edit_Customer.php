<?php
    require_once 'core/handleForms.php';
    require_once 'core/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit customer info</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php $getCustomer_ByID = getCustomer_ByID($pdo, $_GET['customer_id']); ?>
        <h1>Edit customer info</h1>

        <form action="core/handleForms.php?customer_id=<?= $_GET['customer_id']; ?>" method="POST">
            <p>
                <label for="first_Name">First Name</label> 
                <input type="text" name="first_Name" value="<?= $getCustomer_ByID['first_Name']; ?>">
            </p>
            <p>
                <label for="last_Name">Last Name</label> 
                <input type="text" name="last_Name" value="<?= $getCustomer_ByID['last_Name']; ?>">
            </p>
            <p>
                <label for="home_address">Home Address</label> 
                <input type="text" name="home_address" value="<?= $getCustomer_ByID['home_address']; ?>">
            </p>
            <p>
                <label for="contact_Num">Contact Number</label> 
                <input type="text" name="contact_Num" value="<?= $getCustomer_ByID['contact_Num']; ?>">
            </p>
            <p>
                <input type="submit" name="edit_Customer_Btn">
            </p>
        </form>
    </body>
</html>
