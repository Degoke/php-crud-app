<?php
include("config.php");

session_start();

if (isset($_POST["login"])) {
    $error_msg =  "";

    if (empty($_POST["email"])) {
        $error_msg .= "<li>Please Enter your email address</li>";
    }

    if ((!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))) {
        $error_msg .= "<li>Invalid Email</li>";
    }

    if (empty($_POST["password"])) {
        $error_msg .= "<li>Password is required</li>";
    }

    $email = test_input($_POST["email"]);
    $password = md5(test_input($_POST["password"]));

    if (!empty($error_msg)) {
        echo "<p>There was an  error with your form</p><br/>";
        echo "<ul>$error_msg</ul><br/>";
    } else {
        $sql2 = "SELECT * from users WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql2);
        if ($result->num_rows > 0) {
            $details = $result->fetch_assoc();
            $_SESSION["name"] = $details["name"];
            $_SESSION["email"] = $details["email"];
            $_SESSION["valid"] = true;
            header("location:dashboard.php");
        } else {
            echo "<p>invalid login credentials</p>";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>login</h1>
    <form action="login.php" method="POST">
        <label for="email">Email Address</label>
        <input type="email" name="email" />
        <label for="password">Password</label>
        <input type="password" name="password" />
        <input type="submit" name="login" value="Login" />
    </form>
    <h5>Forgot Password? <a href="reset.php">Reset Password</a></h5>
    <h5>Dont Have an account? <a href="register.php">Register</a></h5>
</body>

</html>