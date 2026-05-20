<?php
$host="localhost"; $user="root"; $pass=""; $db="pharmacy";
$conn=new mysqli($host,$user,$pass,$db);
$result=$conn->query("SELECT company, coverage FROM insurance ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head><title>Insurance</title></head>
<body>
<form action="addInsurance.php" method="post">
  Company: <input type="text" name="company"><br>
  Coverage (%): <input type="number" name="coverage"><br>
  <button type="submit">Add Insurance</button>
</form>
<h3>Insurance List</h3>
<?php while($row=$result->fetch_assoc()): ?>
  <?= $row["company"]." - ".$row["coverage"]."%"."<br>" ?>
<?php endwhile; ?>
</body>
</html>
<?php $conn->close(); ?>
