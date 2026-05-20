<?php
$host="localhost"; $user="root"; $pass=""; $db="pharmacy";
$conn=new mysqli($host,$user,$pass,$db);
$name=trim($_POST["name"]);
$stmt=$conn->prepare("INSERT INTO diseases (name) VALUES (?)");
$stmt->bind_param("s",$name);
$stmt->execute();
$stmt->close();
$conn->close();
header("Location: diseases.php");
exit;
?>
