<?php
session_start();
header('Content-Type: application/json');
include '../db.php';

// debug
$response = [];

if (!isset($conn)) {
    $response['success'] = false;
    $response['message'] = 'Connection not defined!';
    echo json_encode($response); exit;
}

if (!isset($_SESSION['user_id'])) {
    $response['success'] = false;
    $response['message'] = 'المستخدم غير مسجّل دخول';
    echo json_encode($response); exit;
}

$user_id = $_SESSION['user_id'];
$amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;

if ($amount <= 0) {
    $response['success'] = false;
    $response['message'] = 'الرجاء اختيار مبلغ صحيح';
    echo json_encode($response); exit;
}

// توليد التاريخ
$bill_type = 'كهرباء';
$billing_date = date('Y-m-d');

// إدخال الفاتورة
$stmt = $conn->prepare("INSERT INTO bills (user_id, bill_type, total_amount, billing_date) VALUES (?, ?, ?, ?)");
if(!$stmt){
    $response['success'] = false;
    $response['message'] = 'خطأ في prepare: ' . $conn->error;
    echo json_encode($response); exit;
}

$stmt->bind_param("isds", $user_id, $bill_type, $amount, $billing_date);
if($stmt->execute()){
    $response['success'] = true;
    $response['message'] = 'تم دفع فاتورة الكهرباء بنجاح';
} else {
    $response['success'] = false;
    $response['message'] = 'خطأ أثناء execute: ' . $stmt->error;
}

echo json_encode($response);
?>
