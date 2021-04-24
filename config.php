<?php 
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "zuri";
 
 $conn = new mysqli($servername, $username, $password, $dbname);
 
 if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
 }

 function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
};

?>