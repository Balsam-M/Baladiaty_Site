<?php
include '../db.php';

if (!isset($conn)) {
    die("Connection not defined!");
}

// الحصول على معرف الموعد
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id <= 0) {
    echo "خطأ: لم يتم تحديد المعرّف الصحيح للمواعيد.";
    exit;
}

// حذف الموعد
$sql = "DELETE FROM appointments WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "خطأ أثناء الحذف: " . $conn->error;
}
?>
