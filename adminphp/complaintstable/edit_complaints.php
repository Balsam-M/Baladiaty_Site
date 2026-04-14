<?php
include '../db.php';

// التأكد من وجود الاتصال
if (!isset($conn)) {
    die("Connection not defined!");
}

// استقبال البيانات من AJAX أو الفورم
$id          = $_POST['id'];
$user_id     = $_POST['user_id'];
$title       = $_POST['title'];
$description = $_POST['description'];
$status      = $_POST['status'];

// بناء جملة الـ UPDATE
$sql = "UPDATE complaints SET 
            user_id = '$user_id', 
            title = '$title', 
            description = '$description', 
            status = '$status'
        WHERE id = '$id'";

// تنفيذ الاستعلام
if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}
?>
