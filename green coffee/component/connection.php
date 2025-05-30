<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "shop_db";
$db_port = 3306;

// More verbose error handling
$conn = new mysqli($db_host, $db_user, $db_password, $db_name, $db_port);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected Successfully to database: " . $db_name;
}
