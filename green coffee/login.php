<?php
include dirname(__FILE__) . '/component/connection.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

// Login user
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['pass']; // Corrected from 'pswd' to 'pass'

    // Sanitize inputs
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Query to fetch user data
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Plain text password verification (since no hashing is used)
        if ($password === $user['password']) { // Fixed password check
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name']; // Fixed from 'username'
            $_SESSION['role'] = $user['role_as']; // Fixed column name

            // Redirect based on role
            if ($user['role_as'] === 'admin') {
                header("Location: admin/admin.php"); // Fixed admin redirect
            } else {
                header("Location: home.php");
            }
            exit(); // Ensure script stops executing after redirect
        } else {
            echo "<script>alert('Invalid password!');</script>";
        }
    } else {
        echo "<script>alert('No user found with this email!');</script>";
    }
}
?>

<style type="text/css">
    <?php include "style.css"; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Green Tea - Login Now</title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="img/download.png">
                <h1>Login Now</h1>
                <p>Welcome back! Please enter your credentials.</p>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>Your Email <sup>*</sup></p>
                    <input type="email" name="email" required placeholder="Enter your email" maxlength="50">
                </div>
                <div class="input-field">
                    <p>Your Password <sup>*</sup></p>
                    <input type="password" name="pass" required placeholder="Enter your password" maxlength="50">
                </div>
                <input type="submit" name="submit" value="Login Now" class="btn">
                <p>Don't have an account? <a href="register.php">Register Now</a></p>
            </form>
        </section>
    </div>
</body>
</html>  
