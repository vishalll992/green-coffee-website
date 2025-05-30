<?php
include dirname(__FILE__) . '/component/connection.php';
session_start();

if (isset($_SESSION['user-id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

// Register user
if (isset($_POST['submit'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);

    // Check if email already exists
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->bind_param("s", $email);
    $select_user->execute();
    $result = $select_user->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        echo 'Email already exists';
    } elseif ($pass !== $cpass) {
        echo 'Passwords do not match';
    } else {
        // Insert user without manually setting ID (MySQL auto-generates it)
        $insert_user = $conn->prepare("INSERT INTO `users` (name, email, password, created_at) VALUES (?, ?, ?, NOW())");
        $insert_user->bind_param("sss", $name, $email, $pass);

        if ($insert_user->execute()) {
            // Fetch the newly inserted user
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
            $select_user->bind_param("s", $email);
            $select_user->execute();
            $result = $select_user->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                header("Location: home.php");
                exit;
            }
        }
    }
}
?>



<style type="text/css">
    <?php include "style.css"?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Green tea - register now</title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="img/download.png">
                <h1>register now</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quis quasi veniam dolores ab aspernatur
                     tenetur
                </p>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>your name <sup>*</sup></p>
                    <input type="text" name="name" required placeholder="enter your name" maxlength="50">
                </div>
                <div class="input-field">
                    <p>your email <sup>*</sup></p>
                    <input type="email" name="email" required placeholder="enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>your password <sup>*</sup></p>
                    <input type="password" name="pass" required placeholder="enter your password" maxlength="50"
                    oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>confirm password <sup>*</sup></p>
                    <input type="password" name="cpass" required placeholder="confirm your password" maxlength="50"
                    oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <input type="submit" name="submit" value="register now" class="btn">
                <p>already have an account? <a href="login.php">login now</a></p>
            </form>
        </section>
    </div>
</body>
</html>
