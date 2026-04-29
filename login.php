<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM employees WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $username;

        echo " Login successful!<br><br>";
        echo "Welcome, " . $username . "<br>";
        echo "<a href='index.html'>Go Back</a>";

    } else {
        echo " Invalid username or password<br><br>";
        echo "<a href='index.html'>Try Again</a>";
    }
}

$conn->close();
?>