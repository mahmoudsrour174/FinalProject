<?php
$host="localhost"; $user="root"; $pass=""; $db="pharmacy";
$conn=new mysqli($host,$user,$pass,$db);
$name=trim($_POST["name"]);
$phone=trim($_POST["phone"]);
$address=trim($_POST["address"]);
$stmt=$conn->prepare("INSERT INTO patients (name, phone, address) VALUES (?, ?, ?)");
$stmt->bind_param("sss",$name,$phone,$address);
$stmt->execute();
$stmt->close();
$conn->close();
header("Location: patients.php");
exit;
?>
