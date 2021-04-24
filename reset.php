<?php
include("config.php");

if (isset($_POST["reset"])) {
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
        $sql2 = "SELECT email from users WHERE email='$email'";
        $result = $conn->query($sql2);
        if ($result->num_rows > 0) {
            $sql3 = "UPDATE users SET password='$password' WHERE email='$email'";
            if ($conn->query($sql3) === TRUE) {
                echo "<h3>Password updated successfully <a href=login.php>Login to continue</a></h3>";
            } else {
                echo "Error updating Password: " . $conn->error;
            }
        } else {
            echo ("<p>User does not exist</p>");
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
    <h1>Reset Password</h1>
    <form action="reset.php" method="POST">
        <label for="email">Email Address</label>
        <input type="email" name="email" />
        <label for="password">New Password</label>
        <input type="password" name="password" />
        <input type="submit" name="reset" value="Reset" />
    </form>
</body>

</html>