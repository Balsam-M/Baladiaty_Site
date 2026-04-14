<?php
include '../db.php';

if (!isset($conn)) die("Connection not defined!");

// استلام البيانات من POST
$user_id      = $_POST['user_id'] ?? '';
$bill_type    = $_POST['bill_type'] ?? '';
$total_amount = $_POST['total_amount'] ?? 0.00;
$billing_date = $_POST['billing_date'] ?? '';

// إدخال البيانات بدون id لأنه Auto Increment
$sql = "INSERT INTO bills (user_id, bill_type, total_amount, billing_date) 
        VALUES ('$user_id', '$bill_type', '$total_amount', '$billing_date')";

if ($conn->query($sql)) {
    // نرجع الرقم الذي ولده MySQL
    $newId = $conn->insert_id;
    echo "success|$newId";
} else {
    echo "error: " . $conn->error;
}
?>
