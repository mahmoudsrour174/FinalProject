<?php
$host="localhost"; $user="root"; $pass=""; $db="pharmacy";
$conn=new mysqli($host,$user,$pass,$db);
$result=$conn->query("SELECT patient_id, amount FROM invoices ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head><title>Invoices</title></head>
<body>
<form action="addInvoice.php" method="post">
  Patient ID: <input type="number" name="patient_id"><br>
  Amount: <input type="number" step="0.01" name="amount"><br>
  <button type="submit">Add Invoice</button>
</form>
<h3>Invoices List</h3>
<?php while($row=$result->fetch_assoc()): ?>
  <?= $row["patient_id"]." - ".$row["amount"]."<br>" ?>
<?php endwhile; ?>
</body>
</html>
<?php $conn->close(); ?>
