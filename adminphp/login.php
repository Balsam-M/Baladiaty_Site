<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

if (!isset($conn)) {
    echo json_encode(["status" => "error", "message" => "فشل الاتصال"]);
    exit;
}

if (!isset($_POST['id']) || !isset($_POST['password'])) {
    echo json_encode(["status" => "error", "message" => "بيانات ناقصة"]);
    exit;
}

$id = $_POST['id'];
$password = $_POST['password'];

/* ================= ADMIN LOGIN ================= */
$adminHashedPassword = '$2y$10$eB1irNcyHR6QNNFYod5rputkwDxyTufYETnT8S/jGLRu1G56rB2YK'; // hash الحقيقي

if ($id === "1111" && password_verify($password, $adminHashedPassword)) {
    $_SESSION['admin_id'] = 1111;
    $_SESSION['admin'] = true;

    echo json_encode([
        "status" => "success",
        "role" => "admin"
    ]);
    exit;
}

/* =============================================== */

// تسجيل دخول المستخدم العادي
$stmt = $conn->prepare("SELECT id, full_name, password FROM users WHERE id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "رقم الهوية غير موجود"]);
    exit;
}

$user = $result->fetch_assoc();

if (password_verify($password, $user['password'])){
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['full_name'] = $user['full_name'];

    echo json_encode([
        "status" => "success",
        "role" => "user"
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "كلمة المرور خاطئة"]);
}