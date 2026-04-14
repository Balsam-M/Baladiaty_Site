<?php
include '../db.php';

if (!isset($conn)) {
    die("Connection not defined!");
}

// الحصول على بيانات POST
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$user_id = isset($_POST['user_id']) ? $conn->real_escape_string($_POST['user_id']) : '';
$appointment_date = isset($_POST['appointment_date']) ? $conn->real_escape_string($_POST['appointment_date']) : '';
$appointment_time = isset($_POST['appointment_time']) ? $conn->real_escape_string($_POST['appointment_time']) : '';
$service_type = isset($_POST['service_type']) ? $conn->real_escape_string($_POST['service_type']) : '';
$status = isset($_POST['status']) ? $conn->real_escape_string($_POST['status']) : '';

if ($id <= 0) {
    echo "خطأ: لم يتم تحديد المعرّف الصحيح للمواعيد.";
    exit;
}

// تحديث البيانات
$sql = "UPDATE appointments 
        SET user_id='$user_id', 
            appointment_date='$appointment_date',
            appointment_time='$appointment_time',
            service_type='$service_type',
            status='$status'
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "خطأ أثناء التحديث: " . $conn->error;
}
?>
