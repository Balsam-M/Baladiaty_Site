<?php
include '../db.php';

if (!isset($conn)) {
    die("Connection not defined!");
}

// استلام البيانات من POST
$content = isset($_POST['content']) ? $conn->real_escape_string($_POST['content']) : '';

// التحقق من أن المحتوى ليس فارغ
if (empty($content)) {
    echo "خطأ: يجب إدخال نص الإعلان";
    exit;
}

// إدخال البيانات في قاعدة البيانات
$sql = "INSERT INTO announcements (content) VALUES ('$content')";

if ($conn->query($sql)) {
    echo 'success';
} else {
    echo "error: " . $conn->error;
}
?>