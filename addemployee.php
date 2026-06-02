<?php
$host="localhost"; $user="root"; $pass=""; $db="pharmacy";
$conn=new mysqli($host,$user,$pass,$db);
$name=trim($_POST["name"]);
$phone=trim($_POST["phone"]);
$address=trim($_POST["address"]);
$job=trim($_POST["job"]);
$salary=intval($_POST["salary"]);
$presence=trim($_POST["presence"]);
$stmt=$conn->prepare("INSERT INTO employees (name, phone, address, job, salary, presence) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssis",$name,$phone,$address,$job,$salary,$presence);
$stmt->execute();
$stmt->close();
$conn->close();
header("Location: employees.php");
exit;
?>
