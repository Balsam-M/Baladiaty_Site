<?php
include '../db.php';

if (!isset($conn)) {
    die("Connection not defined!");
}

if (!isset($_POST['id']) || empty($_POST['id'])) {
    die("error: ID not provided");
}

// استلام البيانات
$id            = intval($_POST['id']);
$user_id       = $_POST['user_id'];
$document_type = $_POST['document_type'];
$details       = $_POST['details'];
$status        = $_POST['status'];

// تحديث البيانات في جدول requests
$sql = "UPDATE requests SET 
            user_id = '$user_id',
            document_type = '$document_type',
            details = '$details',
            status = '$status',
            updated_at = CURRENT_TIMESTAMP
        WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}
?>
