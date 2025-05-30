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

// Update quantity in cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_qty'])) {
        $cart_id = filter_var($_POST['cart_id'], FILTER_VALIDATE_INT);
        $new_qty = filter_var($_POST['qty'], FILTER_VALIDATE_INT);

        if ($cart_id && $new_qty > 0) {
            $update_stmt = $conn->prepare("UPDATE cart SET qty = ? WHERE id = ? AND user_id = ?");
            $update_stmt->bind_param("iii", $new_qty, $cart_id, $user_id);
            
            if ($update_stmt->execute()) {
                $success_msg[] = 'Quantity updated!';
            } else {
                $warning_msg[] = 'Failed to update quantity!';
            }
        } else {
            $warning_msg[] = 'Invalid quantity!';
        }
    }

    // Remove item from cart
    if (isset($_POST['delete_item'])) {
        $cart_id = filter_var($_POST['cart_id'], FILTER_VALIDATE_INT);

        if ($cart_id) {
            $delete_stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
            $delete_stmt->bind_param("ii", $cart_id, $user_id);
            
            if ($delete_stmt->execute()) {
                $success_msg[] = 'Item removed from cart!';
            } else {
                $warning_msg[] = 'Failed to remove item!';
            }
        } else {
            $warning_msg[] = 'Invalid cart ID!';
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
    <title>Shopping Cart</title>
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
        <h1>Shopping Cart</h1>
        <div class="title2">
            <a href="home.php">Home</a><span> / Cart</span>
        </div>

        <section class="products">
            <div class="box-container">
                <?php
                $total_price = 0;
                $select_cart = $conn->prepare("SELECT c.id AS cart_id, p.id AS product_id, p.name, p.image_url, p.price, c.qty FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
                $select_cart->bind_param("i", $user_id);
                $select_cart->execute();
                $result = $select_cart->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $subtotal = $row['price'] * $row['qty'];
                        $total_price += $subtotal;
                ?>
                        <div class="box">
                            <img src="<?= htmlspecialchars($row['image_url']); ?>" class="img">
                            <h3 class="name"><?= htmlspecialchars($row['name']); ?></h3>
                            <p class="price">Price: ₹<?= htmlspecialchars($row['price']); ?></p>
                            
                            <form action="" method="post">
                                <input type="hidden" name="cart_id" value="<?= htmlspecialchars($row['cart_id']); ?>">
                                <input type="number" name="qty" value="<?= htmlspecialchars($row['qty']); ?>" min="1">
                                <button type="submit" name="update_qty"><i class="bx bx-edit"></i> Update</button>
                                <button type="submit" name="delete_item"><i class="bx bx-trash"></i> Remove</button>
                            </form>
                            
                            <p class="subtotal">Subtotal: ₹<?= htmlspecialchars($subtotal); ?></p>
                        </div>
                <?php
                    }
                } else {
                    echo '<p class="empty">Your cart is empty!</p>';
                }
                ?>
            </div>
        </section>

        <!-- Cart Total -->
        <div class="cart-total">
            <h2>Total: ₹<?= htmlspecialchars($total_price); ?></h2>
            <?php if ($total_price > 0): ?>
                <a href="checkout.php" class="btn">Proceed to Checkout</a>
            <?php else: ?>
                <a href="home.php" class="btn">Shop Now</a>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'component/footer.php'; ?>
</body>
</html>
