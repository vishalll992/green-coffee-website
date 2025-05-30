<?php
include 'C:\xampp\htdocs\green coffee (2)\green coffee\component\connection.php';

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Delete order query
    $sql = "DELETE FROM orders WHERE order_id = $order_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Order deleted successfully!'); window.location.href='C:\xampp\htdocs\green coffee (2)\green coffee\admin\orders.php';</script>";
    } else {
        echo "Error deleting order: " . $conn->error;
    }
}
$conn->close();
?>
