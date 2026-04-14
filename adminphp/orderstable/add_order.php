<?php
include '../db.php';

if (!isset($conn)) {
    die("Connection not defined!");
}

// استلام البيانات من POST
$user_id       = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$document_type = isset($_POST['document_type']) ? $_POST['document_type'] : '';
$details       = isset($_POST['details']) ? $_POST['details'] : '';
$status        = isset($_POST['status']) ? $_POST['status'] : 'قيد الانتظار'; // الحالة الافتراضية "قيد الانتظار"

// إدخال البيانات في قاعدة البيانات
$sql = "INSERT INTO requests (user_id, document_type, details, status) 
        VALUES ('$user_id', '$document_type', '$details', '$status')";


if ($conn->query($sql)) {
    echo 'success';
} else {
    echo "error: " . $conn->error;
}
?>
