<?php session_start();
    $user = "root";
    $password = "";

    $dbname = "business_idea";
    $host = "localhost";

    $dsn = "mysql:host={$host};dbname={$dbname}";

    $pdo = new PDO($dsn, $user, $password);
    $pdo->exec("SET time_zone = '+08:00';");
?>