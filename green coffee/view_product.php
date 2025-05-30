<?php
session_start();
include dirname(__FILE__) . '/component/connection.php';

// Check if user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit();
}

// Success & Warning Messages
$success_msg = [];
$warning_msg = [];

/**
 * Function to get product details from database.
 */
function getProduct($conn, $product_id) {
    $stmt = $conn->prepare("SELECT id, price FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

/**
 * Function to insert product into wishlist/cart.
 */
function addItemToDatabase($conn, $table, $user_id, $product_id, $price, $qty = null) {
    try {
        if ($table === 'wishlist') {
            $stmt = $conn->prepare("INSERT INTO wishlist (user_id, product_id, price) VALUES (?, ?, ?)");
            $stmt->bind_param("iid", $user_id, $product_id, $price);
        } else {
            $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, price, qty) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iidi", $user_id, $product_id, $price, $qty);
        }
        return $stmt->execute();
    } catch (Exception $e) {
        return false;
    }
}

// Handle Add to Wishlist
if (isset($_POST['add_to_wishlist'])) {
    if (empty($user_id)) {
        $warning_msg[] = 'You need to login first!';
    } else {
        $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT);
        $product_data = getProduct($conn, $product_id);

        if (!$product_data) {
            $warning_msg[] = 'Error: Product not found!';
        } else {
            // Check if already in wishlist
            $check_stmt = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?");
            $check_stmt->bind_param("ii", $user_id, $product_id);
            $check_stmt->execute();
            $wishlist_result = $check_stmt->get_result();

            if ($wishlist_result->num_rows > 0) {
                $warning_msg[] = 'Product already in wishlist!';
            } else {
                if (addItemToDatabase($conn, 'wishlist', $user_id, $product_id, $product_data['price'])) {
                    $success_msg[] = 'Product added to wishlist!';
                } else {
                    $warning_msg[] = 'Error adding to wishlist!';
                }
            }
        }
    }
}

// Handle Add to Cart
if (isset($_POST['add_to_cart'])) {
    if (empty($user_id)) {
        $warning_msg[] = 'You need to login first!';
    } else {
        $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT);
        $qty = filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);
        $product_data = getProduct($conn, $product_id);

        if (!$product_data) {
            $warning_msg[] = 'Error: Product not found!';
        } else {
            // Check if already in cart
            $check_stmt = $conn->prepare("SELECT id FROM cart WHERE user_id = ? AND product_id = ?");
            $check_stmt->bind_param("ii", $user_id, $product_id);
            $check_stmt->execute();
            $cart_result = $check_stmt->get_result();

            if ($cart_result->num_rows > 0) {
                $warning_msg[] = 'Product already in cart!';
            } else {
                if (addItemToDatabase($conn, 'cart', $user_id, $product_id, $product_data['price'], $qty)) {
                    $success_msg[] = 'Product added to cart!';
                } else {
                    $warning_msg[] = 'Error adding to cart!';
                }
            }
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
    <title>Green Coffee - Shop Page</title>
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
        <div class="banner">
            <h1>Shop</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span> / Our Shop </span>
        </div>

        <section class="products">
            <div class="box-container">
                <?php
                $select_products = $conn->prepare("SELECT * FROM products");
                $select_products->execute();
                $result = $select_products->get_result();

                if ($result->num_rows > 0) {
                    while ($fetch_products = $result->fetch_assoc()) {
                ?>
                        <div class="box">
                            <img src="<?= htmlspecialchars($fetch_products['image_url']); ?>" class="img">
                            <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                            <div class="flex">
                                <p class="price">Price: RS <?= htmlspecialchars($fetch_products['price']); ?>/-</p>
                            </div>

                            <form action="" method="post">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">
                                <input type="number" name="qty" required min="1" max="99" class="qty" value="1">
                                <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                            </form>

                            <form action="" method="post">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">
                                <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                            </form>
                        </div>
                <?php
                    }
                } else {
                    echo '<p class="empty">No products added yet!</p>';
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
