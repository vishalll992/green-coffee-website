<?php
session_start(); // Ensure this is at the top

include __DIR__ . '/component/connection.php';

if (!isset($conn)) {
    die("Database connection failed.");
}

$warning_msg = [];
$success_msg = [];

// Check if user is logged in
$user_id = $_SESSION['user_id'] ?? '';

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit;
}

// Adding product to wishlist
// Adding product to wishlist
if (isset($_POST['add_to_wishlist'])) {
    $id = uniqid();
    $product_id = $_POST['product_id'];

    // Prepare the wishlist query
    $varify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id=? AND product_id=?");
    $varify_wishlist->bind_param("ss", $user_id, $product_id);
    $varify_wishlist->execute();
    $varify_wishlist->store_result(); // Store result to use num_rows

    // Prepare the cart query
    $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id=? AND product_id=?");
    $cart_num->bind_param("ss", $user_id, $product_id);
    $cart_num->execute();
    $cart_num->store_result(); // Store result to use num_rows

    // Check if the product exists in wishlist or cart
    if ($varify_wishlist->num_rows > 0) {
        $warning_msg[] = 'Product already exists in your wishlist!';
    } elseif ($cart_num->num_rows > 0) {
        $warning_msg[] = 'Product already exists in your cart!';
    } else {
        // Get product details
        $select_product = $conn->prepare("SELECT price, name, image FROM `products` WHERE id=? LIMIT 1");
        $select_product->bind_param("s", $product_id);
        $select_product->execute();
        $result = $select_product->get_result();
        $fetch_product = $result->fetch_assoc();

        if ($fetch_product) {
            // Insert product into wishlist
            $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (id, user_id, product_id, price, name, image) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_wishlist->bind_param("ssssss", $id, $user_id, $product_id, $fetch_product['price'], $fetch_product['name'], $fetch_product['image']);
            $insert_wishlist->execute();

            $success_msg[] = 'Product added to wishlist successfully';
        } else {
            $warning_msg[] = 'Product not found!';
        }
    }
}

// Adding product to cart
if (isset($_POST['add_to_cart'])) {
    $id = uniqid();
    $product_id = $_POST['product_id'];
    $qty = filter_var($_POST['qty'], FILTER_SANITIZE_STRING);

    // Check if product already exists in cart
    $varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id=? AND product_id=?");
    $varify_cart->bind_param("ss", $user_id, $product_id);
    $varify_cart->execute();
    $varify_cart_result = $varify_cart->get_result();

    // Get cart count
    $max_cart_item = $conn->prepare("SELECT COUNT(*) FROM `cart` WHERE user_id=?");
    $max_cart_item->bind_param("s", $user_id);
    $max_cart_item->execute();
    $cart_result = $max_cart_item->get_result();
    $row = $cart_result->fetch_assoc();
    $cart_count = $row ? (int) $row['COUNT(*)'] : 0;

    if ($varify_cart_result->num_rows > 0) {
        $warning_msg[] = 'Product already exists in your cart';
    } elseif ($cart_count > 20) {
        $warning_msg[] = 'Cart is full';
    } else {
        // Fetch product details
        $select_product = $conn->prepare("SELECT * FROM `products` WHERE id=? LIMIT 1");
        $select_product->bind_param("s", $product_id);
        $select_product->execute();
        $product_result = $select_product->get_result();

        if ($fetch_product = $product_result->fetch_assoc()) {
            // Insert into cart
            $insert_cart = $conn->prepare("INSERT INTO `cart` (id, user_id, product_id, price, qty, name, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insert_cart->bind_param("sssssss", $id, $user_id, $product_id, $fetch_product['price'], $qty, $fetch_product['name'], $fetch_product['image']);
            $insert_cart->execute();

            $success_msg[] = 'Product added to cart successfully';
        } else {
            $warning_msg[] = 'Product not found!';
        }
    }
}

?>
