<?php
include("config.php");

session_start();

if (isset($_POST["register"])) {
    $error_msg =  "";

    if (empty($_POST["name"])) {
        $error_msg .= "<li>Name is required</li>";
    }

    if (empty($_POST["email"])) {
        $error_msg .= "<li>Please Enter your email address</li>";
    }

    if ((!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))) {
        $error_msg .= "<li>Invalid Email</li>";
    }

    if (empty($_POST["password"])) {
        $error_msg .= "<li>Password is required</li>";
    }

    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $password = md5(test_input($_POST["password"]));

    if (!empty($error_msg)) {
        echo "<p>There was an  error with your form</p><br/>";
        echo "<ul>$error_msg</ul><br/>";
    } else {
        $sql2 = "SELECT email from users WHERE email='$email'";
        $result = $conn->query($sql2);
        if ($result->num_rows > 0) {
            echo "<p>email already exists</p>";
        } else {
            $sql = "INSERT INTO users (name, email, password)
            VALUES ('$name', '$email', '$password')";

            if ($conn->query($sql) === TRUE) {
                echo "Registration Successfull";
            } else {
                echo "Error: " . $sql . "<br/>" . $conn->error;
            }
            $_SESSION["name"] = $name;
            $_SESSION["email"] = $email;
            $_SESSION["valid"] = true;
            header("location:dashboard.php");
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
    <h1>Register</h1>
    <form action="register.php" method="POST">
        <label for="name">Username</label>
        <input type="text" name="name" />
        <label for="email">Email Address</label>
        <input type="email" name="email" />
        <label for="password">Password</label>
        <input type="password" name="password" />
        <input type="submit" name="register" value="Register" />
    </form>
    <h4>Already have an account <a href="login.php">Login</a></h4>
</body>

</html>