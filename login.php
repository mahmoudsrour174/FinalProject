<?php
include "db.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

   if ($result->num_rows > 0) {
        header("Location: drugs.html");
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>