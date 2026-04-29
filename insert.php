<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $price = $_POST['price'];

    $sql = "INSERT INTO drugs 
    (name, scientific_name, barcode, sell_price, cost_price, quantity, production_date, expiry, store_condition, details, supplier_id)
    VALUES 
    ('$name', '', '', '$price', 0, 0, CURDATE(), CURDATE(), '', '', 1)";
    echo $sql;

    if ($conn->query($sql) === TRUE) {
        echo " Drug added successfully!";
    } else {
        echo " Error: " . $conn->error;
    }
}
?>