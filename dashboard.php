<?php
include("config.php");

session_start();

if (!$_SESSION["valid"]) {
    header("location:index.php");
}

if (isset($_POST["logout"])) {
    session_destroy();
    header("location:index.php");
}

if (isset($_POST["addcourse"])) {
    $error_msg = "";

    if (empty($_POST["name"])) {
        $error_msg .= "<li>Course name is required</li>";
    }

    if (empty($_POST["details"])) {
        $error_msg .= "<li>Course details is required</li>";
    }

    if (!empty($error_msg)) {
        echo "<p>There was an  error with your form</p><br/>";
        echo "<ul>$error_msg</ul><br>";
    } else {
        $name = test_input($_POST["name"]);
        $details = test_input($_POST["details"]);
        $author = $_SESSION["email"];

        $sql = "INSERT INTO courses (author, name, details) VALUES ('$author', '$name', '$details')";

        if ($conn->query($sql) === TRUE) {
            header("location:dashboard.php");
        } else {
            echo "Error adding course";
        }
    }
}

if (isset($_POST["editcourse"])) {
    $error_msg = "";

    if (empty($_POST["id"])) {
        $error_msg .= "<li>Course id is required</li>";
    }

    if (empty($_POST["details"]) or empty($_POST["name"])) {
        $error_msg .= "<li>Enter details and name to edit</li>";
    }

    if (!empty($error_msg)) {
        echo ("<p>There was an  error with your form</p><br/>");
        echo ("<ul>$error_msg</ul><br>");
    } else {
        $name = test_input($_POST["name"]);
        $details = test_input($_POST["details"]);
        $id = test_input($_POST["id"]);

        $sql = "SELECT id FROM courses WHERE id=$id ";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $sql1 = "UPDATE courses SET name='$name', details='$details' WHERE id=$id";
            if ($conn->query($sql1) === TRUE) {
                header("location:dashboard.php");
                echo "course successfully edited";
            } else {
                echo "Error updating Password: " . $conn->error;
            }
        } else {
            echo "Course does not exist";
        }
    }
}

if (isset($_POST["delete"])) {
    if (empty($_POST["id"])) {
        $error_msg .= "<li>Course id is required</li>";
    }

    if (!empty($error_msg)) {
        echo ("<p>There was an  error with your form</p><br/>");
        echo ("<ul>$error_msg</ul><br>");
    } else {
        $id = test_input($_POST["id"]);

        $sql = "SELECT id FROM courses WHERE id=$id ";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $sql1 = "DELETE FROM courses WHERE id=$id";
            if ($conn->query($sql1) === TRUE) {
                header("location:dashboard.php");
                echo "course successfully deleted";
            } else {
                echo "Error updating Password: " . $conn->error;
            }
        }
        else {
            echo "Course does not exist";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Welcome To your Dashboard <?php echo ($_SESSION["name"]) ?></h1>
    <br />
    <form action="dashboard.php" method="POST">
        <input type="submit" name="logout" value="Logout" />
    </form>
    <br />
    <form action="dashboard.php" method="POST">
        <h3>Add a course</h3>
        <label for="course">Course name</label>
        <input type="text" name="name" />
        <label for="details">Course Details</label>
        <textarea name="details" rows="3" cols="50"></textarea>
        <input type="submit" name="addcourse" value="Add Course" />
    </form>
    <br />
    <h2>Courses</h2>
    <?php
    $sql = "SELECT name, id, details FROM courses where author='$_SESSION[email]' ORDER BY id DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<ul>
                <li>
                <p>Name: $row[name]<br>
                id: $row[id]</p>
                <p>Details: $row[details]</p></li>
                </ul>";
        }
    } else {
        echo "<p>No courses added</p>";
    }

    ?>
    <form action="dashboard.php" method="POST">
        <h3>Edit a course</h3>
        <label for="id">course id</label>
        <input type="number" name="id" />
        <label for="name">Course name</label>
        <input type="text" name="name" />
        <label for="details">Course Details</label>
        <textarea name="details" rows="3" cols="50"></textarea>
        <input type="submit" name="editcourse" value="Edit Course" />
    </form>
    <br>
    <form action="dashboard.php" method="POST">
        <h3>Delete a course</h3>
        <label for="course">course id</label>
        <input type="number" name="id" />
        <input type="submit" name="delete" value="Delete Course" />
    </form>
</body>

</html>