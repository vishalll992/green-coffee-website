<?php
include('C:\xampp\htdocs\green coffee (2)\green coffee\component\connection.php');

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    echo "Attempting to delete Product ID: " . $id . "<br>";

    // Check if the product exists
    $check_query = $conn->prepare("SELECT id FROM products WHERE id = ?");
    $check_query->bind_param("i", $id);
    $check_query->execute();
    $result = $check_query->get_result();

    if ($result->num_rows > 0) {
        echo "Product found. Proceeding with deletion...<br>";

        // Delete product
        $delete_query = $conn->prepare("DELETE FROM products WHERE id = ?");
        $delete_query->bind_param("i", $id);

        if ($delete_query->execute()) {
            echo "Product deleted successfully! <br>";
        } else {
            echo "Error deleting product: " . $delete_query->error . "<br>";
        }
    } else {
        echo "Product not found.<br>";
    }
} else {
    echo "Invalid request.<br>";
}
?>
