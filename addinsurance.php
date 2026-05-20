<?php
$host="localhost"; $user="root"; $pass=""; $db="pharmacy";
$conn=new mysqli($host,$user,$pass,$db);
$company=trim($_POST["company"]);
$coverage=intval($_POST["coverage"]);
$stmt=$conn->prepare("INSERT INTO insurance (company, coverage) VALUES (?, ?)");
$stmt->bind_param("si",$company,$coverage);
$stmt->execute();
$stmt->close();
$conn->close();
header("Location: insurance.php");
exit;
?>