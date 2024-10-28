<?php 
    require_once 'core/dbConfig.php';
    require_once 'core/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete customer record</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1>Are you sure you want to delete this customer?</h1>

        <?php $getCustomer_ByID = getCustomer_ByID($pdo, $_GET['customer_id']); ?>

        <div class="container" style="border-style: solid; height: 400px;">
            <h2>Username: <?= $getCustomer_ByID['username']; ?></h2>
            <h2>First Name: <?= $getCustomer_ByID['first_Name']; ?></h2>
            <h2>Last Name: <?= $getCustomer_ByID['last_Name']; ?></h2>
            <h2>Home Address: <?= $getCustomer_ByID['home_address']; ?></h2>
            <h2>Contact #: <?= $getCustomer_ByID['contact_Num']; ?></h2>
            <h2>Date Added: <?= $getCustomer_ByID['date_added']; ?></h2>

            <div class="deleteBtn" style="float: right; margin-right: 10px;">
                <form action="core/handleForms.php?customer_id=<?= $_GET['customer_id']; ?>" method="POST">
                    <input type="submit" name="del_Customer_Btn" value="Delete">
                </form>			
            </div>
        </div>
    </body>
</html>
