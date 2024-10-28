<?php
    require_once 'dbConfig.php';
    require_once 'functions.php';


    
    /* --- USERS --- */
    // REGISTER
    if (isset($_POST['btn_Register'])) {

        if (!empty($_POST['username']) && !empty($_POST['password'])) {

            $username = sanitizeInput($_POST['username']);

            if (validatePassword($_POST['password'])) { // check password strength

                $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // encrypt password

                if (register($pdo, $username, $password)) { // add user

                    header('Location: ../index.php');

                } else { // already registered
                    echo '<script>
                        alert("Username already exists");
                        window.location.href = "../login.php";
                    </script>';
                }
            } else { // weak password
                echo '<script>
                    alert("Password should be more than 8 characters and should contain both uppercase, lowercase, and numbers.");
                    window.location.href = "../register.php";
                </script>';
            }
        } else { // missing info
            echo '<script>
                alert("Missing info");
                window.location.href = "../register.php";
            </script>';
        }
    }

    // LOGIN
    if (isset($_POST['btn_Login'])) {

        $username = sanitizeInput($_POST['username']);
        $password = $_POST['password'];

        if (!empty($username) && !empty($password)) {

            if (login($pdo, $username, $password)) { // login successful

                header("Location: ../index.php?");
                
            } else { // wrong input
                echo '<script>
                    alert("INCORRECT username or password");
                    window.location.href = "../login.php";
                </script>';
            }
        } else { // missing info
            echo '<script>
                alert("Missing info");
                window.location.href = "../login.php";
            </script>';
        }
    }



    /* --- CUSTOMERS --- */
    // ADD
    if (isset($_POST['add_Customer_Btn'])) {
        $username = sanitizeInput($_POST['username']);
        $first_Name = sanitizeInput($_POST['first_Name']);
        $last_Name = sanitizeInput($_POST['last_Name']);
        $home_address = sanitizeInput($_POST['home_address']);
        $contact_Num = sanitizeInput($_POST['contact_Num']);
        $added_by = $_SESSION['username'];

        if (!empty($username) && !empty($first_Name) && !empty($last_Name) && !empty($home_address) && !empty($contact_Num)) {
            
            $query = addCustomer($pdo, $username, $first_Name, $last_Name, $home_address, $contact_Num, $added_by); 

            if ($query) {
                header("Location: ../index.php");
            } else {
                echo "AAAAAAAAAAAAAAAA";
            }

        } else {
            echo "There are empty fields";
        }
    }

    // UPDATE
    if (isset($_POST['edit_Customer_Btn'])) {
        $first_Name = sanitizeInput($_POST['first_Name']);
        $last_Name = sanitizeInput($_POST['last_Name']);
        $home_address = sanitizeInput($_POST['home_address']);
        $contact_Num = sanitizeInput($_POST['contact_Num']);
        $updated_by = $_SESSION['username'];

        if (!empty($first_Name) && !empty($last_Name) && !empty($home_address) && !empty($contact_Num)) {
            
            $query = editCustomer($pdo, $first_Name, $last_Name, $home_address, $contact_Num, $updated_by); 

            if ($query) {
                header("Location: ../index.php");
            } else {
                echo "AAAAAAAAAAAAAAAA";
            }

        } else {
            echo "There are empty fields";
        }
    }

    // DELETE
    if (isset($_POST['del_Customer_Btn'])) {
        $query1 = deleteCustomer($pdo, $_GET['customer_id']);
        $query2 = recordDeletion_ofCustomer($pdo, $_GET['customer_id'], $_SESSION['username']);

        if ($query1 && $query2) {
            header("Location: ../index.php");
        } else {
            echo "AAAAAAAAAAAA";
        }
    }



    /* --- ORDERS --- */
    // ADD
    if (isset($_POST['add_Order_Btn'])) {
        $order_Name = sanitizeInput($_POST['order_Name']);
        $order_Quantity = sanitizeInput($_POST['order_Quantity']);
        $order_Price = sanitizeInput($_POST['order_Price']);
        $added_by = $_SESSION['username'];

        if (!empty($order_Name && !empty($order_Quantity)) && !empty($order_Price)) {
            
            $query = addOrder($pdo, $order_Name, $order_Quantity, $order_Price, $_GET['customer_id'], $added_by);
            
            if ($query) {
                header("Location: ../view_Orders.php?customer_id=" . $_GET['customer_id']);
            } else {
                echo "AAAAAAAAAAAAAAAA";
            }

        } else {
            echo 'There are empty fields';
        }
    }

    // UPDATE
    if (isset($_POST['edit_Order_Btn'])) {
        $order_Name = sanitizeInput($_POST['order_Name']);
        $order_Quantity = sanitizeInput($_POST['order_Quantity']);
        $order_Price = sanitizeInput($_POST['order_Price']);
        $updated_by = $_SESSION['username'];
        
        if (!empty($order_Name && !empty($order_Quantity)) && !empty($order_Price)) {
            
            $query = editOrder($pdo, $order_Name, $order_Quantity, $order_Price, $_GET['order_id'], $updated_by);
            
            if ($query) {
                header("Location: ../view_Orders.php?customer_id=" . $_GET['customer_id']);
            } else {
                echo "AAAAAAAAAAAAAAAA";
            }

        } else {
            echo 'There are empty fields';
        }
    }

    // DELETE
    if (isset($_POST['del_Order_Btn'])) {
        $query1 = deleteOrder($pdo, $_GET['order_id']);
        
        $query2 = recordDeletion_ofOrder($pdo, $_GET['customer_id'], $_GET['order_id'], $_SESSION['username']);

        if ($query1 && $query2) {
            header("Location: ../view_Orders.php?customer_id=" . $_GET['customer_id']);
        } else {
            echo "AAAAAAAAAAAA";
        }
    }
?>