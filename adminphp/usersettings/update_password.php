<?php
session_start();
include '../db.php';

if (!isset($conn)) {
    die("Connection not defined!");
}

$id = $_SESSION['user_id'];
$new = $_POST['new'] ?? '';
$confirm = $_POST['confirm'] ?? '';

if($new !== $confirm){
    die("❌ كلمة المرور غير متطابقة");
}

if(strlen($new) < 6){
    die("❌ كلمة المرور يجب أن تكون 6 أحرف على الأقل");
}

$newHash = password_hash($new,PASSWORD_DEFAULT);
$u = $conn->prepare("UPDATE users SET password=? WHERE id=?");
$u->bind_param("si",$newHash,$id);
$u->execute();

echo "✅ تم تغيير كلمة المرور بنجاح";
