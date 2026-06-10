<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $barcode = trim($_POST['barcode'] ?? '');
    $sell_price = $_POST['sell_price'] ?? '';
    $cost_price = $_POST['cost_price'] ?? '';
    $quantity = $_POST['quantity'] ?? '';
    $scientific_name = trim($_POST['scientific_name'] ?? '');
    $production_date = $_POST['production_date'] ?: null;
    $expiry = $_POST['expiry'] ?: null;
    $store_condition = trim($_POST['store_condition'] ?? '');
    $drug_interactions = trim($_POST['drug_interactions'] ?? '');
    if ($name === '' || $sell_price === '' || $quantity === '') {
        $message = 'Name, sell price, and quantity are required.';
    } else {
        $sell_price = floatval($sell_price);
        $cost_price = floatval($cost_price);
        $quantity = intval($quantity);
        $stmt = $conn->prepare('INSERT INTO drugs (name, barcode, sell_price, cost_price, quantity, scientific_name, production_date, expiry, store_condition, details) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssddisssss', $name, $barcode, $sell_price, $cost_price, $quantity, $scientific_name, $production_date, $expiry, $store_condition, $drug_interactions);
        if ($stmt->execute()) {
            $stmt->close();
            header('Location: drugs.php');
            exit;
        }
        $message = 'Unable to save drug.';
    }
}
$result = $conn->query('SELECT id, name, barcode, sell_price, cost_price, quantity, expiry, scientific_name, details FROM drugs');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Drugs - Pharmacy</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="page-layout">
    <aside class="sidebar">
      <h2>Menu</h2>
      <nav>
        <a href="patients.php">Patients</a>
        <a href="drugs.php">Drugs</a>
        <a href="employees.php">Employees</a>
        <a href="suppliers.php">Suppliers</a>
        <a href="invoices.php">Invoices</a>
        <a href="insurance.php">Insurance</a>
        <a href="diseases.php">Diseases</a>
        <a href="logout.php">Logout</a>
      </nav>
    </aside>
    <main class="content">
      <header><h1>Drugs</h1></header>
      <?php if ($message): ?>
      <section class="messages"><p><?php echo htmlspecialchars($message); ?></p></section>
      <?php endif; ?>
      <section class="page-section form-section">
        <h2>Add Drug</h2>
        <form method="post">
          <label>Name<br><input type="text" name="name" required></label>
          <label>Barcode<br><input type="text" name="barcode"></label>
          <label>Sell Price<br><input type="number" step="0.01" name="sell_price" required></label>
          <label>Cost Price<br><input type="number" step="0.01" name="cost_price"></label>
          <label>Quantity<br><input type="number" name="quantity" required></label>
          <label>Scientific Name<br><input type="text" name="scientific_name"></label>
          <label>Production Date<br><input type="date" name="production_date"></label>
          <label>Expiry<br><input type="date" name="expiry"></label>
          <label>Store Condition<br><input type="text" name="store_condition"></label>
          <label>Interactions<br><input type="text" name="drug_interactions"></label>
          <button type="submit">Add Drug</button>
        </form>
      </section>
      <section class="page-section table-section">
        <h2>Drug Inventory</h2>
        <table>
          <thead>
            <tr><th>ID</th><th>Name</th><th>Barcode</th><th>Sell Price</th><th>Cost Price</th><th>Quantity</th><th>Expiry</th><th>Scientific Name</th><th>Details</th></tr>
          </thead>
          <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['id']) ?></td>
              <td><?php echo htmlspecialchars($row['name']) ?></td>
              <td><?php echo htmlspecialchars($row['barcode']) ?></td>
              <td><?php echo htmlspecialchars($row['sell_price']) ?></td>
              <td><?php echo htmlspecialchars($row['cost_price']) ?></td>
              <td><?php echo htmlspecialchars($row['quantity']) ?></td>
              <td><?php echo htmlspecialchars($row['expiry']) ?></td>
              <td><?php echo htmlspecialchars($row['scientific_name']) ?></td>
              <td><?php echo htmlspecialchars($row['details']) ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </section>
    </main>
  </div>
</body>
</html>


