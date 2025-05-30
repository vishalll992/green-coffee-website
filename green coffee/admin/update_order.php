<?php
session_start();
include 'C:\xampp\htdocs\green coffee (2)\green coffee\component\connection.php';

$order_id = $_GET['order_id'] ?? '';

if (empty($order_id)) {
    die("Order ID is missing!");
}

// Fetch existing order data using prepared statement
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $name = $row['name'];
    $number = $row['number'];
    $email = $row['email'];
    $payment_method = $row['payment_method'];
    
    // Corrected Address Fields
    $flat = $row['flat'];
    $street = $row['street'];
    $city = $row['city'];
    $pincode = $row['pincode'];
    $country = $row['country'];

    // $status = $row['order_status'];
} else {
    die("Order not found!");
}
$stmt->close();

// Handle order update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $name = trim($_POST['name']);
    $number = trim($_POST['number']);
    $email = trim($_POST['email']);
    $payment_method = $_POST['payment_method'];
    
    // Updated Address Fields
    $flat = trim($_POST['flat']);
    $street = trim($_POST['street']);
    $city = trim($_POST['city']);
    $pincode = trim($_POST['pincode']);
    $country = trim($_POST['country']);

    $status = $_POST['order_status'];

    // Update query using prepared statements
    $update_stmt = $conn->prepare("UPDATE orders SET name=?, number=?, email=?, payment_method=?, flat=?, street=?, city=?, pincode=?, country=?, order_status=? WHERE order_id=?");
    $update_stmt->bind_param("ssssssssssi", $name, $number, $email, $payment_method, $flat, $street, $city, $pincode, $country, $status, $order_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Order updated successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error updating order: " . $conn->error . "');</script>";
    }
    $update_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            background: #28a745;
            color: #fff;
            padding: 10px;
            margin-top: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Update Order</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($name); ?>" required>

        <label>Number:</label>
        <input type="text" name="number" value="<?= htmlspecialchars($number); ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email); ?>" required>

        <label>Flat/Apartment:</label>
        <input type="text" name="flat" value="<?= htmlspecialchars($flat); ?>" required>

        <label>Street:</label>
        <input type="text" name="street" value="<?= htmlspecialchars($street); ?>" required>

        <label>City:</label>
        <input type="text" name="city" value="<?= htmlspecialchars($city); ?>" required>

        <label>Pincode:</label>
        <input type="text" name="pincode" value="<?= htmlspecialchars($pincode); ?>" required>

        <label>Country:</label>
        <input type="text" name="country" value="<?= htmlspecialchars($country); ?>" required>

        <label>Payment Method:</label>
        <select name="payment_method">
            <option value="cash on delivery" <?= ($payment_method == 'cash on delivery') ? 'selected' : ''; ?>>Cash on Delivery</option>
            <!-- <option value="credit card" <?= ($payment_method == 'credit card') ? 'selected' : ''; ?>>Credit Card</option>
            <option value="paypal" <?= ($payment_method == 'paypal') ? 'selected' : ''; ?>>PayPal</option> -->
        </select>

        <label>Order Status:</label>
        <select name="order_status">
            <option value="Pending" <?= ($status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
            <option value="Processing" <?= ($status == 'Processing') ? 'selected' : ''; ?>>Processing</option>
            <option value="Shipped" <?= ($status == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
            <option value="Delivered" <?= ($status == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
            <option value="Cancelled" <?= ($status == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
        </select>

        <button type="submit" name="update">Update Order</button>
    </form>
</div>

</body>
</html>
