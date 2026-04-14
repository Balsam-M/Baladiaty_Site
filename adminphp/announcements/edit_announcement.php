<?php
include '../db.php';

if (!isset($conn)) {
    die("Connection not defined!");
}

if (!isset($_POST['id']) || empty($_POST['id'])) {
    die("error: ID not provided");
}

// استلام البيانات
$id      = intval($_POST['id']);
$content = isset($_POST['content']) ? $conn->real_escape_string($_POST['content']) : '';

// تحديث المحتوى في جدول announcements
$sql = "UPDATE announcements SET 
            content = '$content',
            created_at = CURRENT_TIMESTAMP
        WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}
?>