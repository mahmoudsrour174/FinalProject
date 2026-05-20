<?php
$host="localhost"; $user="root"; $pass=""; $db="pharmacy";
$conn=new mysqli($host,$user,$pass,$db);
$result=$conn->query("SELECT name, phone, address FROM patients ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head><title>Patients</title></head>
<body>
<form action="addPatient.php" method="post">
  Name: <input type="text" name="name"><br>
  Phone: <input type="text" name="phone"><br>
  Address: <input type="text" name="address"><br>
  <button type="submit">Add Patient</button>
</form>
<h3>Patient List</h3>
<?php while($row=$result->fetch_assoc()): ?>
  <?= $row["name"]." - ".$row["phone"]." - ".$row["address"]."<br>" ?>
<?php endwhile; ?>
</body>
</html>
<?php $conn->close(); ?>
