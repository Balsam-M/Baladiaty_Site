<?php
header('Content-Type: application/json; charset=UTF-8');

ini_set('display_errors', 0);
error_reporting(0);

include 'db.php';

if (!isset($conn)) {
    echo json_encode(["success" => false, "message" => "فشل الاتصال بقاعدة البيانات"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "طريقة الطلب غير مسموحة"]);
    exit;
}

$id = isset($_POST['id']) ? trim($_POST['id']) : '';
$first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
$last_name  = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
$full_name  = trim($first_name . ' ' . $last_name);

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$date_of_birth = isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : '';
$city = isset($_POST['city']) ? trim($_POST['city']) : '';
$street = isset($_POST['street']) ? trim($_POST['street']) : '';
$visa_number = isset($_POST['visa_number']) ? trim($_POST['visa_number']) : '';
if (
    $full_name === '' || $email === '' || $password === '' ||
    $phone === '' || $date_of_birth === '' ||
    $city === '' || $street === '' || $visa_number === ''
) {
    echo json_encode(["success" => false, "message" => "الرجاء تعبئة جميع الحقول"]);
    exit;
}

// تشفير كلمة المرور
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// إدخال البيانات
$stmt = $conn->prepare("
    INSERT INTO users
    (id,full_name, email, password, phone, date_of_birth, city, street, visa_number)
    VALUES (?,?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "sssssssss",
    $id,
    $full_name,
    $email,
    $hashed_password,
    $phone,
    $date_of_birth,
    $city,
    $street,
    $visa_number
);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "تم إنشاء الحساب بنجاح 🎉"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "خطأ أثناء إنشاء الحساب"
    ]);
}

$stmt->close();
$conn->close();