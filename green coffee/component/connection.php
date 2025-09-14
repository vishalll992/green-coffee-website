<?php
$db_host = "db";               // must match the service name in docker-compose.yml
$db_user = "shop_user";
$db_password = "userpassword";
$db_name = "shop_db";
$db_port = 3306;

$conn = new mysqli($db_host, $db_user, $db_password, $db_name, $db_port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
