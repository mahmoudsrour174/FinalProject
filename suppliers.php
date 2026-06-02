<?php
$host="localhost"; $user="root"; $pass=""; $db="pharmacy";
$conn=new mysqli($host,$user,$pass,$db);
$result=$conn->query("SELECT company_name, supplier_phone FROM suppliers ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head><title>Suppliers</title></head>
<body>
<form action="addSupplier.php" method="post">
  Company Name: <input type="text" name="company_name"><br>
  Phone: <input type="text" name="supplier_phone"><br>
  <button type="submit">Add Supplier</button>
</form>
<h3>Supplier List</h3>
<?php while($row=$result->fetch_assoc()): ?>
  <?= $row["company_name"]." - ".$row["supplier_phone"]."<br>" ?>
<?php endwhile; ?>
</body>
</html>
<?php $conn->close(); ?>
