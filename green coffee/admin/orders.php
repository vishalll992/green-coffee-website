<?php
include 'C:\xampp\htdocs\green coffee (2)\green coffee\component\connection.php'; // Include your database connection

// Fetch orders from the database
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
?>

<style>
    table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

th {
    background-color: #2E8B57; /* Green */
    color: white;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}

</style>

<table border="1">
    <tr>
        <th>Order ID</th>
        <th>User ID</th>
        <th>Name</th>
        <th>Number</th>
        <th>Email</th>
        <th>Payment Method</th>
        <th>Address</th>
        <th>City</th>
        <th>Pincode</th>
        <th>Order Date</th>
        <th>Actions</th>
    </tr>
    
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['order_id']}</td>
            <td>{$row['user_id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['number']}</td>
            <td>{$row['email']}</td>
            <td>{$row['payment_method']}</td>
            <td>{$row['flat']}, {$row['street']}</td>
            <td>{$row['city']}</td>
            <td>{$row['pincode']}</td>
            <td>{$row['order_date']}</td>
            <td>
                <a href='update_order.php?order_id={$row['order_id']}'>Edit</a> | 
                <a href='delete_order.php?order_id={$row['order_id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
            </td>
        </tr>";
    }
    ?>
</table>
