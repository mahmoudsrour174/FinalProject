<?php
$host="localhost"; $user="root"; $pass=""; $db="pharmacy";
$conn=new mysqli($host,$user,$pass,$db);
$company_name=trim($_POST["company_name"]);
$supplier_phone=trim($_POST["supplier_phone"]);
$stmt=$conn->prepare("INSERT INTO suppliers (company_name, supplier_phone) VALUES (?, ?)");
$stmt->bind_param("ss",$company_name,$supplier_phone);
$stmt->execute();
$stmt->close();
$conn->close();
header("Location: suppliers.php");
exit;
?>
