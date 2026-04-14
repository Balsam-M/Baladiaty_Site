<?php
include '../db.php';

if (!isset($conn)) die("Connection not defined!");

// استلام البيانات من POST
$user_id     = $_POST['user_id'] ?? '';
$title       = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$status      = $_POST['status'] ?? 'قيد الانتظار'; // القيمة الافتراضية إذا ما أرسل شيء

// إدخال البيانات بدون id لأنه Auto Increment
$sql = "INSERT INTO complaints (user_id, title, description, status) 
        VALUES ('$user_id', '$title', '$description', '$status')";

if ($conn->query($sql)) {
    // نرجع الرقم الذي ولده MySQL
    $newId = $conn->insert_id;
    echo "success|$newId";
} else {
    echo "error: " . $conn->error;
}
?>
