<?php
include 'component/connection.php';
session_start();

$user_id = $_SESSION['user_id'] ?? '';

// Redirect if not logged in
if (!$user_id) {
    header("Location: login.php");
    exit();
}

// Success & Warning Messages
$success_msg = [];
$warning_msg = [];

// Add product to cart from wishlist
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $product_id = filter_var($_POST['product_id'], FILTER_VALIDATE_INT);
        $qty = 1;

        if ($product_id) {
            // Check if product is already in cart
            $stmt = $conn->prepare("SELECT id FROM cart WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $warning_msg[] = 'Product already in cart!';
            } else {
                // Fetch product price
                $price_stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
                $price_stmt->bind_param("i", $product_id);
                $price_stmt->execute();
                $price_stmt->bind_result($price);
                $price_stmt->fetch();
                $price_stmt->close();

                if ($price) {
                    // Insert into cart
                    $insert_cart = $conn->prepare("INSERT INTO cart (user_id, product_id, price, qty) VALUES (?, ?, ?, ?)");
                    $insert_cart->bind_param("iidi", $user_id, $product_id, $price, $qty);

                    if ($insert_cart->execute()) {
                        $success_msg[] = 'Product added to cart!';
                    } else {
                        $warning_msg[] = 'Failed to add product to cart!';
                    }
                } else {
                    $warning_msg[] = 'Product not found!';
                }
            }
            $stmt->close();
        } else {
            $warning_msg[] = 'Invalid product ID!';
        }
    }

    // Remove item from wishlist
    if (isset($_POST['delete_item'])) {
        $wishlist_id = filter_var($_POST['wishlist_id'], FILTER_VALIDATE_INT);

        if ($wishlist_id) {
            $delete_stmt = $conn->prepare("DELETE FROM wishlist WHERE id = ? AND user_id = ?");
            $delete_stmt->bind_param("ii", $wishlist_id, $user_id);

            if ($delete_stmt->execute()) {
                $success_msg[] = 'Item removed from wishlist!';
            } else {
                $warning_msg[] = 'Failed to remove item!';
            }
        } else {
            $warning_msg[] = 'Invalid wishlist ID!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Wishlist</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'component/header.php'; ?>

    <!-- Success & Warning Messages -->
    <?php if (!empty($success_msg)): ?>
        <div class="success">
            <?php foreach ($success_msg as $msg) echo "<p>$msg</p>"; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($warning_msg)): ?>
        <div class="warning">
            <?php foreach ($warning_msg as $msg) echo "<p>$msg</p>"; ?>
        </div>
    <?php endif; ?>

    <div class="main">
        <h1>My Wishlist</h1>
        <div class="title2">
            <a href="home.php">Home</a><span> / Wishlist</span>
        </div>

        <section class="products">
            <div class="box-container">
                <?php
                // Fetch wishlist items
                $select_wishlist = $conn->prepare("
                    SELECT w.id AS wishlist_id, p.id AS product_id, p.name, p.image_url, p.price 
                    FROM wishlist w 
                    JOIN products p ON w.product_id = p.id 
                    WHERE w.user_id = ?
                ");
                $select_wishlist->bind_param("i", $user_id);
                $select_wishlist->execute();
                $result = $select_wishlist->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Ensure wishlist_id exists
                        if (empty($row['wishlist_id'])) {
                            echo "<p class='error'>Error: Wishlist ID is missing for product " . htmlspecialchars($row['name']) . "</p>";
                            continue;
                        }
                ?>
                        <div class="box">
                            <img src="<?= htmlspecialchars($row['image_url']); ?>" class="img">
                            <h3 class="name"><?= htmlspecialchars($row['name']); ?></h3>
                            <p class="price">Price: ₹<?= htmlspecialchars($row['price']); ?></p>

                            <form action="" method="post">
                                <input type="hidden" name="wishlist_id" value="<?= htmlspecialchars($row['wishlist_id']); ?>">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($row['product_id']); ?>">
                                <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i> Add to Cart</button>
                                <button type="submit" name="delete_item"><i class="bx bx-trash"></i> Remove</button>
                            </form>
                        </div>
                <?php
                    }
                } else {
                    echo '<p class="empty">Your wishlist is empty!</p>';
                }
                ?>
            </div>
        </section>

        <?php include 'component/footer.php'; ?>
    </div>

    <script src="script.js"></script>
    <?php include 'component/alert.php'; ?>
</body>

</html>
