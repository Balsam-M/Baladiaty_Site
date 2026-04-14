<?php
include '../db.php';

// التأكد من وجود الاتصال
if (!isset($conn)) {
    die("Connection not defined!");
}

// استقبال البيانات من AJAX أو الفورم
$id           = $_POST['id'];
$user_id      = $_POST['user_id'];
$bill_type    = $_POST['bill_type'];
$total_amount = $_POST['total_amount'];
$billing_date = $_POST['billing_date'];

// بناء جملة الـ UPDATE
$sql = "UPDATE bills SET 
            user_id = '$user_id', 
            bill_type = '$bill_type', 
            total_amount = '$total_amount', 
            billing_date = '$billing_date'
        WHERE id = '$id'";

// تنفيذ الاستعلام
if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}
?>
