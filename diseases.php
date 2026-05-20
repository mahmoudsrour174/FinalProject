<?php
$host="localhost"; $user="root"; $pass=""; $db="pharmacy";
$conn=new mysqli($host,$user,$pass,$db);
$result=$conn->query("SELECT name FROM diseases ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head><title>Diseases</title></head>
<body>
<form action="addDisease.php" method="post">
  Name: <input type="text" name="name"><br>
  <button type="submit">Add Disease</button>
</form>
<h3>Disease List</h3>
<?php while($row=$result->fetch_assoc()): ?>
  <?= $row["name"]."<br>" ?>
<?php endwhile; ?>
</body>
</html>
<?php $conn->close(); ?>
