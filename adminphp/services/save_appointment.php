<?php
session_start();
include '../db.php';
if (!isset($conn)) die("Connection not defined!");


$user_id = $_SESSION['user_id'] ?? 0;
$date = $_POST['appointment_date'] ?? '';
$time = $_POST['appointment_time'] ?? '';
$service = $_POST['service_type'] ?? '';

if(!$user_id || !$date || !$time || !$service){
    echo json_encode(["success"=>false,"message"=>"بيانات ناقصة"]);
    exit;
}

/* تحقق العدد */
$check = $conn->prepare(
    "SELECT COUNT(*) AS total 
     FROM appointments 
     WHERE appointment_date=? AND appointment_time=?"
);
$check->bind_param("ss",$date,$time);
$check->execute();
$res = $check->get_result()->fetch_assoc();

if($res['total'] >= 2){
    echo json_encode(["success"=>false,"message"=>"الساعة ممتلئة"]);
    exit;
}

/* إدخال */
$insert = $conn->prepare(
    "INSERT INTO appointments 
    (user_id, appointment_date, appointment_time, service_type)
    VALUES (?,?,?,?)"
);
$insert->bind_param("isss",$user_id,$date,$time,$service);
$insert->execute();

echo json_encode(["success"=>true,"message"=>"تم الحجز بنجاح"]);