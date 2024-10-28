<?php
    /* --- USERS --- */
    function register($pdo, $username, $password) {
        // check if user is already in database
        $sql = "SELECT * FROM user_credentials WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([$username]);

        // add user to database
        if ($stmt->rowCount() == 0) { // true means user is not yet registered
            $sql = "INSERT INTO user_credentials (username, password) VALUES (?,?)";
            $stmt = $pdo->prepare($sql);

            return $stmt->execute([$username, $password]);
        }
    }

    function login($pdo, $username, $password) {
        // check if user is in database
        $query = "SELECT * FROM user_credentials WHERE username = ?";
        $stmt = $pdo->prepare($query);

        $stmt->execute([$username]);

        // verify user information
        if ($stmt->rowCount() == 1) { // there can only be one row per user (one uid, uName, uPass)
            $row = $stmt->fetch();

            $_SESSION['userinfo'] = $row;

            $uid = $row['user_id'];
            $uName = $row['username'];
            $uPass = $row['password'];

            if (password_verify($password, $uPass)) { // password given vs password from database
                $_SESSION['user_id'] = $uid;
                $_SESSION['username'] = $uName;
                $_SESSION['userLoginStatus'] = 1;
                return true;
            } else {
                return false;
            }
        }
    }


    
    /* --- DELETE LOGS --- */
    // FETCH
    function getAll_Customer_DeleteLogs($pdo) {
        $sql = "SELECT * FROM delete_logs WHERE order_id IS NULL";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute();

        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    function getAll_Order_DeleteLogs($pdo, $customer_id) {
        // all orders specific to a customer
        $sql = "SELECT * FROM delete_logs WHERE customer_id = ?";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$customer_id]);

        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // RECORD
    function recordDeletion_ofCustomer($pdo, $customer_id, $deleted_by) {
        $sql = "INSERT INTO delete_logs (customer_id, deleted_by) VALUES (?,?)";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$customer_id, $deleted_by]);

        if ($executeQuery) {
            return true;
        }
    }

    function recordDeletion_ofOrder($pdo, $customer_id, $order_id, $deleted_by) {
        $sql = "INSERT INTO delete_logs (customer_id, order_id, deleted_by) VALUES (?,?,?)";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$customer_id, $order_id, $deleted_by]);

        if ($executeQuery) {
            return true;
        }
    }

    

    /* --- INPUT SECURITY --- */
    function validatePassword($password) {
        if (strlen($password) > 8) { // longer than 8 char
            $hasLower = false;
            $hasUpper = false;
            $hasNumber = false;

            for ($i = 0; $i < strlen($password); $i++) {
                if (ctype_lower($password[$i])) { // has lower case
                    $hasLower = true; 
                }
                elseif (ctype_upper($password[$i])) { // has upper case
                    $hasUpper = true; 
                }
                elseif (ctype_digit($password[$i])) { // has numbers
                    $hasNumber = true;
                }
                
                if ($hasLower && $hasUpper && $hasNumber) {
                    return true; 
                }
            }
        } else {
            return false; 
        }
    }
    
    function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }



    /* --- CUSTOMERS --- */
    // FETCH ALL
    function getAllCustomers($pdo) {
        $sql = "SELECT * FROM customers";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute();

        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // FETCH
    function getCustomer_ByID($pdo, $customer_id) {
        $sql = "SELECT * FROM customers WHERE customer_id = ?";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$customer_id]);

        if ($executeQuery) {
            return $query->fetch();
        }
    }

    // ADD
    function addCustomer($pdo, $username, $first_Name, $last_Name, $home, $contact, $added_by) {
        $sql = "INSERT INTO customers (username, first_Name, last_Name, home_address, contact_Num, added_by) VALUES (?,?,?,?,?,?)";   

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$username, $first_Name, $last_Name, $home, $contact, $added_by]);

        if ($executeQuery) {
            return true;
        }
    }

    // UPDATE
    function editCustomer($pdo, $first_Name, $last_Name, $home, $contact, $updated_by) {
        $sql = "UPDATE customers
                    SET first_Name = ?,
                        last_Name = ?,
                        home_address = ?, 
                        contact_Num = ?,
                        updated_by = ?
                    WHERE customer_id = ?
                ";   

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$first_Name, $last_Name, $home, $contact, $updated_by, $_GET['customer_id']]);

        if ($executeQuery) {
            return true;
        }
    }

    // DELETE
    function deleteCustomer($pdo, $customer_id) {
        $remove_fromOrders = "DELETE FROM orders WHERE customer_id = ?";

        $query_Remove = $pdo->prepare($remove_fromOrders);
        $executeRemoval = $query_Remove->execute([$customer_id]);

        if ($executeRemoval) {
            $sql = "DELETE FROM customers WHERE customer_id = ?";

            $query = $pdo->prepare($sql);
            $executeQuery = $query->execute([$customer_id]);

            if ($executeQuery) {
                return true;
            }
        }
    }



    /* --- ORDERS --- */
    // FETCH ALL
    function getAllOrders_OfCustomer($pdo, $customer_id) {
        
        $sql = "SELECT 
                    orders.order_id AS order_id,
                    orders.order_Name AS order_Name,
                    orders.order_Quantity AS order_Quantity,
                    orders.order_Price AS order_Price,
                    orders.added_by AS added_by,
                    orders.date_added AS date_added,
                    orders.updated_by AS updated_by,
                    orders.last_updated AS last_updated,
                    CONCAT(customers.first_Name,' ',customers.last_Name) AS customer
                FROM orders
                JOIN customers ON orders.customer_id = customers.customer_id
                WHERE orders.customer_id = ? 
                GROUP BY orders.order_Name;
                ";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$customer_id]);

        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // FETCH
    function getOneOrder_OfCustomer($pdo, $order_id) {
        
        $sql = "SELECT 
                    orders.order_id AS order_id,
                    orders.order_Name AS order_Name,
                    orders.order_Quantity AS order_Quantity,
                    orders.order_Price AS order_Price,
                    orders.added_by AS added_by,
                    orders.date_added AS date_added,
                    orders.updated_by AS updated_by,
                    orders.last_updated AS last_updated,
                    CONCAT(customers.first_Name,' ',customers.last_Name) AS customer
                FROM orders
                JOIN customers ON orders.customer_id = customers.customer_id
                WHERE orders.order_id = ? 
                GROUP BY orders.order_Name;
                ";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$order_id]);

        if ($executeQuery) {
            return $query->fetch();
        }
    }

    // ADD
    function addOrder($pdo, $order_Name, $order_Quantity, $order_Price, $customer_id, $added_by) {
        $sql = "INSERT INTO orders (order_Name, order_Quantity, order_Price, customer_id, added_by) VALUES (?,?,?,?,?)";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$order_Name, $order_Quantity, $order_Price, $customer_id, $added_by]);

        if ($executeQuery) {
            return true;
        }
    }

    // UPDATE
    function editOrder($pdo, $order_Name, $order_Quantity, $order_Price, $order_id, $updated_by) {
        $sql = "UPDATE orders
                SET order_Name = ?,
                    order_Quantity = ?,
                    order_Price = ?,
                    updated_by = ?
                WHERE order_id = ?
                ";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$order_Name, $order_Quantity, $order_Price, $updated_by, $order_id]);

        if ($executeQuery) {
            return true;
        }
    }

    // DELETE
    function deleteOrder($pdo, $order_id) {
        $sql = "DELETE FROM orders WHERE order_id = ?";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$order_id]);

        if ($executeQuery) {
            return true;
        }
    }
?>