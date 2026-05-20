<?php
include 'connection.php';
$result = $conn->query("SELECT * FROM drugs");
?>

<table>
  <thead>
    <tr>
      <th>Name</th><th>Barcode</th><th>Sell Price</th><th>Cost Price</th>
      <th>Quantity</th><th>Expiry</th><th>Active Ingredient</th><th>Interactions</th>
    </tr>
  </thead>
  <tbody>
    <?php while($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?= $row['name'] ?></td>
        <td><?= $row['barcode'] ?></td>
        <td><?= $row['sell_price'] ?></td>
        <td><?= $row['cost_price'] ?></td>
        <td><?= $row['quantity'] ?></td>
        <td><?= $row['expiry'] ?></td>
        <td><?= $row['scientific_name'] ?></td>
        <td><?= $row['details'] ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
