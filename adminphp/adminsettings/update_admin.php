<?php
session_start();
include '../db.php';

if (!isset($conn)) {
    die(json_encode(['status' => 'error', 'message' => 'Connection not defined!']));
}

$id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : 1111;

$fullName = isset($_POST['full_name']) ? $_POST['full_name'] : '';
$email    = isset($_POST['email']) ? $_POST['email'] : '';
$phone    = isset($_POST['phone']) ? $_POST['phone'] : '';
$city     = isset($_POST['city']) ? $_POST['city'] : '';
$street   = isset($_POST['street']) ? $_POST['street'] : '';
$visa     = isset($_POST['visa_number']) ? $_POST['visa_number'] : '';
$newPass  = isset($_POST['new_password']) ? $_POST['new_password'] : '';
$confirm  = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

if(empty($fullName) || empty($email)) {
    echo json_encode(['status' => 'error', 'message' => 'الاسم الكامل والبريد الإلكتروني مطلوبان!']);
    exit;
}

$updates = [];
$updates[] = "full_name='" . $conn->real_escape_string($fullName) . "'";
$updates[] = "email='" . $conn->real_escape_string($email) . "'";
$updates[] = "phone='" . $conn->real_escape_string($phone) . "'";
$updates[] = "city='" . $conn->real_escape_string($city) . "'";
$updates[] = "street='" . $conn->real_escape_string($street) . "'";
$updates[] = "visa_number='" . $conn->real_escape_string($visa) . "'";

if(!empty($newPass)) {
    if($newPass !== $confirm) {
        echo json_encode(['status' => 'error', 'message' => 'كلمة المرور الجديدة لا تتطابق مع التأكيد!']);
        exit;
    }
    $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
    $updates[] = "password='" . $conn->real_escape_string($hashedPass) . "'";
}

$sql = "UPDATE users SET " . implode(", ", $updates) . " WHERE id=$id";

if ($conn->query($sql)) {
    // إرجاع البيانات المحدثة بعد الحفظ
    echo json_encode([
        'status' => 'success',
        'full_name' => $fullName,
        'email' => $email,
        'phone' => $phone,
        'city' => $city,
        'street' => $street,
        'visa_number' => $visa
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}
?>
