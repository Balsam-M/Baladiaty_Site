<?php
include '../db.php';

if (!isset($conn)) {
    die("Connection not defined!");
}

// قراءة البيانات من الفورم
$user_id       = isset($_POST['user_id']) ? $conn->real_escape_string($_POST['user_id']) : '';
$appointment_date = isset($_POST['appointment_date']) ? $conn->real_escape_string($_POST['appointment_date']) : '';
$appointment_time = isset($_POST['appointment_time']) ? $conn->real_escape_string($_POST['appointment_time']) : '';
$service_type   = isset($_POST['service_type']) ? $conn->real_escape_string($_POST['service_type']) : '';
$status         = isset($_POST['status']) ? $conn->real_escape_string($_POST['status']) : 'pending';

// تحقق من القيم المطلوبة
if (empty($user_id) || empty($appointment_date)) {
    echo "خطأ: رقم المستخدم والتاريخ مطلوبان!";
    exit;
}

// جملة SQL للإضافة
$sql = "INSERT INTO appointments (user_id, appointment_date, appointment_time, service_type, status)
        VALUES ('$user_id', '$appointment_date', '$appointment_time', '$service_type', '$status')";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "خطأ أثناء الإضافة: " . $conn->error;
}
?>
