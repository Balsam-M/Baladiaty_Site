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
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$notes = $_POST['notes'] ?? '';

if(empty($title) || empty($description)){
    echo json_encode([
        "success"=>false,
        "message"=>"يرجى اختيار نوع الشكوى"
    ]);
    exit;
}

$fullDescription = $description;
if(!empty($notes)){
    $fullDescription .= " | ملاحظات: ".$notes;
}

$stmt = $conn->prepare("
    INSERT INTO complaints (user_id, title, description, status)
    VALUES (?, ?, ?, 'قيد الانتظار')
");

$stmt->bind_param("iss", $user_id, $title, $fullDescription);

if($stmt->execute()){
    echo json_encode([
        "success"=>true,
        "message"=>"تم إرسال الشكوى بنجاح، سيتم متابعتها قريبًا"
    ]);
}else{
    echo json_encode([
        "success"=>false,
        "message"=>"حدث خطأ أثناء إرسال الشكوى"
    ]);
}
