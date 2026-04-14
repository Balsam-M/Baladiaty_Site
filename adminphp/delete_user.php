<?php
include 'db.php';

// التأكد من وجود الاتصال
if (!isset($conn)) {
    die("Connection not defined!");
}

// التأكد أن الـ ID موجود ومُرسل
if (!isset($_POST['id']) || empty($_POST['id'])) {
    die("error: ID not provided");
}

$id = intval($_POST['id']); // تحويل الرقم إلى عدد صحيح لتجنب أي مشاكل

// تنفيذ الحذف
$sql = "DELETE FROM users WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}
?>