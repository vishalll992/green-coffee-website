<?php
session_start();

include 'C:\xampp\htdocs\green coffee (2)\green coffee\component\connection.php';

// Fetch statistics
$total_users_query = "SELECT COUNT(*) AS total_users FROM users";
$total_users_result = $conn->query($total_users_query);
$total_users = $total_users_result->fetch_assoc()['total_users'] ?? 0;

$total_products_query = "SELECT COUNT(*) AS total_products FROM products";
$total_products_result = $conn->query($total_products_query);
$total_products = $total_products_result->fetch_assoc()['total_products'] ?? 0;

$total_orders_query = "SELECT COUNT(*) AS total_orders FROM orders";
$total_orders_result = $conn->query($total_orders_query);
$total_orders = $total_orders_result->fetch_assoc()['total_orders'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin-style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Adding jQuery for simplicity -->
</head>
<style>
    /* Reset Default Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    /* Layout */
    body {
        display: flex;
        height: 100vh;
        background-color: #f5f5f5;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        background: #2E8B57;
        /* Forest Green */
        color: #fff;
        padding: 20px;
        position: fixed;
        height: 100%;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
    }

    .sidebar .logo h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 22px;
    }

    .sidebar nav ul {
        list-style: none;
    }

    .sidebar nav ul li {
        padding: 12px 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        transition: 0.3s;
    }

    .sidebar nav ul li a {
        text-decoration: none;
        color: #fff;
        font-size: 18px;
        display: block;
        transition: 0.3s;
    }

    .sidebar nav ul li:hover {
        background: #3CB371;
        /* Medium Sea Green */
    }

    /* Main Content */
    .main-content {
        margin-left: 250px;
        flex: 1;
        padding: 20px;
        background: #ffffff;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Navbar */
    .navbar {
        background: #2E8B57;
        color: white;
        padding: 15px;
        text-align: right;
        font-size: 16px;
        border-radius: 5px;
    }

    /* Dashboard Stats */
    .dashboard-stats {
        display: flex;
        justify-content: space-between;
        margin: 20px 0;
    }

    .dashboard-stats div {
        background: #3CB371;
        color: white;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
        flex: 1;
        margin: 0 10px;
        font-size: 18px;
        font-weight: bold;
    }

    .dashboard-stats div:first-child {
        margin-left: 0;
    }

    .dashboard-stats div:last-child {
        margin-right: 0;
    }

    /* Dynamic Content */
    #content {
        margin-top: 20px;
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .main-content {
            margin-left: 200px;
        }

        .dashboard-stats {
            flex-direction: column;
        }

        .dashboard-stats div {
            margin: 10px 0;
        }
    }
</style>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h2>Admin Panel</h2>
        </div>
        <nav>
            <ul>
                <li><a href="#" onclick="showPage('dashboard')">Dashboard</a></li>
                <li><a href="#" onclick="showPage('products')">Products</a></li>
                <li><a href="#" onclick="showPage('orders')">Orders</a></li>
                <li><a href="#" onclick="showPage('users')">Users</a></li>
                <li><a href="logout.php">Logout</a></li>
                </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="navbar">
            <span>Welcome, <?php echo isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Admin'; ?>!</span>
        </div>

        <!-- Dashboard Stats -->
        <div class="dashboard-stats">
            <div>Total Users: <?php echo $total_users; ?></div>
            <div>Total Products: <?php echo $total_products; ?></div>
            <div>Total Orders: <?php echo $total_orders; ?></div>
        </div>

        <!-- Dynamic Content Section -->
        <div id="content">
            <!-- Default content can go here or a placeholder -->
            <h2>Welcome to the Admin Dashboard</h2>
            <p>Select a section from the sidebar to manage your products, orders, or users.</p>
        </div>
    </div>

    <script>
        function showPage(page) {
            $.ajax({
                url: page + '.php', // Loads products.php dynamically
                type: 'GET',
                success: function(response) {
                    $('#content').html(response);
                }
            });
        }
    </script>

</body>

</html>