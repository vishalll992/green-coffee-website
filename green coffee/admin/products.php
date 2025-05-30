<?php
include('C:\xampp\htdocs\green coffee (2)\green coffee\component\connection.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch all products
$products_query = "SELECT id, name, image_url, price FROM products";
$products_result = $conn->query($products_query);

// Check if query execution failed
if (!$products_result) {
    die("Error in SQL Query: " . $conn->error); // Debugging statement
}

if (isset($_GET['deleted'])) {
    echo "<div class='alert alert-success'>Product deleted successfully!</div>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .delete-btn {
            color: red;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <h2>All Products</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = $products_result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td>
                        <img src="../images/<?= htmlspecialchars($product['image_url']) ?>" onerror="this.src=''" alt="<?= htmlspecialchars($product['name']) ?>">
                    </td>
                    <td>₹<?= number_format($product['price'], 2) ?></td>
                    <td>
                        <a href="delete_product.php?id=<?= $row['id']; ?>"
                            onclick="return confirm('Are you sure you want to delete this product?');">
                            Remove
                        </a>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>

</html>