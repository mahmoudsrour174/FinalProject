<?php
$host="localhost"; $user="root"; $pass=""; $db="pharmacy";
$conn=new mysqli($host,$user,$pass,$db);
$result=$conn->query("SELECT name, phone, job, salary FROM employees ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head><title>Employees</title></head>
<body>
<form action="addEmployee.php" method="post">
  Name: <input type="text" name="name"><br>
  Phone: <input type="text" name="phone"><br>
  Address: <input type="text" name="address"><br>
  Job: <input type="text" name="job"><br>
  Salary: <input type="number" name="salary"><br>
  Presence: <input type="text" name="presence"><br>
  <button type="submit">Add Employee</button>
</form>
<h3>Employee List</h3>
<?php while($row=$result->fetch_assoc()): ?>
  <?= $row["name"]." - ".$row["phone"]." - ".$row["job"]." - ".$row["salary"]."<br>" ?>
<?php endwhile; ?>
</body>
</html>
<?php $conn->close(); ?>
