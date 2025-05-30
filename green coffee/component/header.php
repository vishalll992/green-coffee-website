<?php
include 'C:\xampp\htdocs\green coffee (2)\green coffee\component\connection.php';

// Check if the user is logged in
$user_id = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? 'Guest';
$user_email = $_SESSION['user_email'] ?? 'Not Available';

// Fetch user email if missing
if (!empty($user_id) && empty($_SESSION['user_email'])) {
    $query = $conn->prepare("SELECT email FROM users WHERE id = ?");
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $_SESSION['user_email'] = $row['email']; // Store in session
        $user_email = $row['email'];
    }
}

// Handle logout
if (isset($_POST['logout'])) {
    session_unset();  // Clear session variables
    session_destroy(); // Destroy session
    header("Location: login.php");
    exit();
}

// Initialize variables for wishlist and cart counts
$total_wishlist_items = 0;
$total_cart_items = 0;

if (!empty($user_id)) {
    // Wishlist count
    $count_wishlist_items = $conn->prepare("SELECT COUNT(*) AS count FROM wishlist WHERE user_id = ?");
    $count_wishlist_items->bind_param("i", $user_id);
    $count_wishlist_items->execute();
    $result_wishlist = $count_wishlist_items->get_result();
    $wishlist_row = $result_wishlist->fetch_assoc();
    $total_wishlist_items = $wishlist_row['count'] ?? 0;

    // Cart count
    $count_cart_items = $conn->prepare("SELECT COUNT(*) AS count FROM cart WHERE user_id = ?");
    $count_cart_items->bind_param("i", $user_id);
    $count_cart_items->execute();
    $result_cart = $count_cart_items->get_result();
    $cart_row = $result_cart->fetch_assoc();
    $total_cart_items = $cart_row['count'] ?? 0;
}
?>

<header class="header">
    <div class="flex">
        <a href="home.php" class="logo"><img src="img/logo.jpg"></a>
        <nav class="navbar">
            <a href="home.php">home</a>
            <a href="view_product.php">products</a>
            <a href="about.php">about us</a>
            <a href="contact.php">contact us</a>
        </nav>

        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>
            <a href="wishlist.php" class="cart-btn">
                <i class="bx bx-heart"></i><sup><?= $total_wishlist_items ?></sup>
            </a>
            <a href="cart.php" class="cart-btn">
                <i class="bx bx-cart-download"></i><sup><?= $total_cart_items ?></sup>
            </a>
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 2rem;"></i>
        </div>

        <div class="user-box">
            <p>Username: <span><?= htmlspecialchars($username); ?></span></p>
            <p>Email: <span><?= htmlspecialchars($user_email); ?></span></p>

            <?php if (!empty($user_id)) { ?>
                <form method="post">
                    <button type="submit" name="logout" class="logout-btn">Log Out</button>
                </form>
            <?php } else { ?>
                <a href="login.php" class="btn">Login</a>
                <a href="register.php" class="btn">Register</a>
            <?php } ?>
        </div>
    </div>
</header>
