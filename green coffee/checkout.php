<?php
include dirname(__FILE__) . '/component/connection.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit();
}

if (isset($_POST['place_order'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $payment_method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
    $flat = filter_var($_POST['flat'], FILTER_SANITIZE_STRING);
    $street = filter_var($_POST['street'], FILTER_SANITIZE_STRING);
    $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
    $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
    $pincode = filter_var($_POST['pincode'], FILTER_SANITIZE_STRING);

    $stmt = $conn->prepare("INSERT INTO `orders` (user_id, name, number, email, payment_method, flat, street, city, country, pincode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssss", $user_id, $name, $number, $email, $payment_method, $flat, $street, $city, $country, $pincode);
    $stmt->execute();
    $stmt->close();

    echo '<script>
            window.onload = function() {
                swal("Order Placed!", "Your order has been placed successfully!", "success")
                    .then(() => {
                        window.location.href = "home.php";
                    });
            }
          </script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Green Coffee - Checkout Page</title>
</head>
<style>
    /* General Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #f4f4f4;
    color: #333;
}

a {
    text-decoration: none;
    color: #333;
}

h1, h3 {
    color: #333;
    font-size: 24px;
    margin-bottom: 20px;
}

/* Checkout Section */
.checkout {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

.checkout .title {
    text-align: center;
    margin-bottom: 30px;
}

.checkout .logo {
    width: 150px;
    margin-bottom: 20px;
}

.checkout h1 {
    font-size: 28px;
    color: #333;
}

.checkout p {
    color: #777;
}

.checkout .row {
    display: flex;
    justify-content: space-between;
    width: 100%;
}

.checkout .box {
    width: 48%;
    margin-bottom: 20px;
}

.checkout .input-field {
    margin-bottom: 15px;
}

.checkout .input-field p {
    margin-bottom: 5px;
    font-size: 14px;
}

.checkout .input {
    width: 100%;
    padding: 10px;
    margin-bottom: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.checkout .input:focus {
    border-color: #009688;
    outline: none;
}

.checkout select {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.checkout .btn {
    width: 100%;
    padding: 15px;
    background-color:#D0F0C0;
    color: black;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.checkout .btn:hover {
    background-color:rgb(102, 173, 142);
}

/* Summary Section */
.summary {
    width: 40%;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.summary .box-container {
    max-height: 400px;
    overflow-y: auto;
    margin-bottom: 20px;
}

.summary .box-container .flex {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.summary .product-img {
    margin-right: 20px;
}

.summary .name {
    font-weight: bold;
}

.summary .price {
    font-size: 14px;
    color: #555;
}

.summary .empty {
    text-align: center;
    font-size: 18px;
    color: #999;
}

.grand-total {
    font-size: 18px;
    font-weight: bold;
    text-align: right;
    margin-top: 20px;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .checkout .row {
        flex-direction: column;
    }

    .checkout .box {
        width: 100%;
    }

    .summary {
        width: 100%;
        margin-top: 20px;
    }
}

@media (max-width: 480px) {
    .checkout h1 {
        font-size: 24px;
    }

    .checkout .title h1 {
        font-size: 20px;
    }
}
</style>
<body>
    <?php include 'component/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Checkout Summary</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/Checkout Summary</span>
        </div>
        <section class="checkout">
            <form method="post">
                <h3>Billing Details</h3>
                <div class="flex">
                    <div class="box">
                        <div class="input-field">
                            <p>Your Name <span>*</span></p>
                            <input type="text" name="name" required placeholder="Enter Your Name" class="input">
                        </div>
                        <div class="input-field">
                            <p>Your Number <span>*</span></p>
                            <input type="number" name="number" required placeholder="Enter Your Number" class="input">
                        </div>
                        <div class="input-field">
                            <p>Your Email <span>*</span></p>
                            <input type="email" name="email" required placeholder="Enter Your Email" class="input">
                        </div>
                        <div class="input-field">
                            <p>Payment Method <span>*</span></p>
                            <select name="method" class="input">
                                <option value="cash on delivery">Cash on Delivery</option>
                                <!-- <option value="credit or debit card">Credit or Debit Card</option>
                                <option value="net banking">Net Banking</option>
                                <option value="UPI or RuPay">UPI or RuPay</option>
                                <option value="paytm">Paytm</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="box">
                        <div class="input-field">
                            <p>Address <span>*</span></p>
                            <input type="text" name="flat" required placeholder="Flat and Building Number" class="input">
                            <input type="text" name="street" required placeholder="Street Name" class="input">
                        </div>
                        <div class="input-field">
                            <p>City <span>*</span></p>
                            <input type="text" name="city" required placeholder="Enter Your City" class="input">
                        </div>
                        <div class="input-field">
                            <p>Country <span>*</span></p>
                            <input type="text" name="country" required placeholder="Enter Your Country" class="input">
                        </div>
                        <div class="input-field">
                            <p>Pincode <span>*</span></p>
                            <input type="text" name="pincode" required placeholder="110022" class="input">
                        </div>
                    </div>
                </div>
                <button type="submit" name="place_order" class="btn">Place Order</button>
            </form>
            <div class="summary">
                <h3>My Bag</h3>
                <div class="box-container">
                    <?php
                        $grand_total = 0;
                        $query = "SELECT * FROM `cart` WHERE user_id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($fetch_cart = $result->fetch_assoc()) {
                            $product_id = $fetch_cart['product_id'];
                            $product_query = "SELECT * FROM `products` WHERE id = ?";
                            $product_stmt = $conn->prepare($product_query);
                            $product_stmt->bind_param("i", $product_id);
                            $product_stmt->execute();
                            $product_result = $product_stmt->get_result();
                            $fetch_product = $product_result->fetch_assoc();
                            $sub_total = $fetch_cart['qty'] * $fetch_product['price'];
                            $grand_total += $sub_total;
                    ?>
                    <div class="flex">
                        <img src="<?= htmlspecialchars($fetch_product['image_url']); ?>" alt="Product Image" class="product-img" style="width: 100px; height: 100px;">
                        <div>
                            <h3 class="name"><?= htmlspecialchars($fetch_product['name']); ?></h3>
                            <p class="price"><?= htmlspecialchars($fetch_product['price']); ?> X <?= htmlspecialchars($fetch_cart['qty']); ?></p>
                        </div>
                    </div>
                    <?php
                        }
                        $stmt->close();
                    ?>
                </div>
                <div class="grand-total">Total Amount Payable: <?= $grand_total ?>/-</div>
            </div>
        </section>
        <?php include 'component/footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
