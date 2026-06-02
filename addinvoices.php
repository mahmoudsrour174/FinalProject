<?php
$host="localhost"; $user="root"; $pass=""; $db="pharmacy";
$conn=new mysqli($host,$user,$pass,$db);
$patient_id=intval($_POST["patient_id"]);
$amount=floatval($_POST["amount"]);
$stmt=$conn->prepare("INSERT INTO invoices (patient_id, amount) VALUES (?, ?)");
$stmt->bind_param("id",$patient_id,$amount);
$stmt->execute();
$stmt->close();
$conn->close();
header("Location: invoices.php");
exit;
?>
