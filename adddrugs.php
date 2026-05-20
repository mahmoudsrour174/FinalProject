<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $barcode = $_POST['barcode'];
    $sell_price = $_POST['sell_price'];
    $cost_price = $_POST['cost_price'];
    $quantity = $_POST['quantity'];
    $scientific_name = $_POST['scientific_name'];
    $production_date = $_POST['production_date'];
    $expiry = $_POST['expiry'];
    $store_condition = $_POST['store_condition'];
    $active_ingredient = $_POST['active_ingredient'];
    $drug_interactions = $_POST['drug_interactions'];

    $sql = "INSERT INTO drugs 
            (name, barcode, sell_price, cost_price, quantity, scientific_name, production_date, expiry, store_condition, details) 
            VALUES 
            ('$name', '$barcode', '$sell_price', '$cost_price', '$quantity', '$scientific_name', '$production_date', '$expiry', '$store_condition', '$drug_interactions')";

    if ($conn->query($sql) === TRUE) {
        echo "New drug added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
