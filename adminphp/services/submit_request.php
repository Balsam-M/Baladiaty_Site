<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success"=>false,"message"=>"غير مصرح"]);
    exit;
}
if (!isset($conn)) {
    die("Connection not defined!");
}
$user_id = $_SESSION['user_id'];
$document_type = $_POST['document_type'];
$details = $_POST['details'];
$notes = $_POST['notes'] ?? '';



if(empty($document_type) || empty($details)){
    echo json_encode([
        "success"=>false,
        "message"=>"يرجى اختيار نوع المعاملة"
    ]);
    exit;
}

$fullDescription = $details;
if(!empty($notes)){
    $fullDescription .= " | ملاحظات: ".$notes;
}


$stmt = $conn->prepare("
    INSERT INTO requests (user_id, document_type, details, status)
    VALUES (?, ?, ?, 'قيد الانتظار')
");

$stmt->bind_param("iss", $user_id, $document_type, $fullDescription);

if($stmt->execute()){
    echo json_encode([
        "success"=>true,
        "message"=>"تم إرسال الطلب بنجاح، الحالة: قيد الانتظار"
    ]);
}else{
    echo json_encode([
        "success"=>false,
        "message"=>"حدث خطأ أثناء الإرسال"
    ]);
}