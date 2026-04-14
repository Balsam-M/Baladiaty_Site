<?php
include 'db.php';

if (!isset($conn)) {
    die("Connection not defined!");
}

// استلام البيانات من POST
$id         = isset($_POST['id']) ? $_POST['id'] : '';
$full_name  = isset($_POST['full_name']) ? $_POST['full_name'] : '';
$email      = isset($_POST['email']) ? $_POST['email'] : '';
$password   = isset($_POST['password']) ? $_POST['password'] : ''; // كلمة المرور
$phone        = isset($_POST['phone']) ? $_POST['phone'] : '';
$date_of_birth= isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : '';
$city       = isset($_POST['city']) ? $_POST['city'] : '';
$street     = isset($_POST['street']) ? $_POST['street'] : '';
$visa_number       = isset($_POST['visa_number']) ? $_POST['visa_number'] : '';

// تشفير الباسوورد (أفضل أماناً)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// إدخال البيانات في قاعدة البيانات
$sql = "INSERT INTO users (id, full_name, email, password, phone, date_of_birth, city, street, visa_number) 
        VALUES ('$id', '$full_name', '$email', '$hashed_password', '$phone', '$date_of_birth', '$city', '$street', '$visa_number')";

if ($conn->query($sql)) {
    echo 'success';
} else {
    echo "error: " . $conn->error;
}
?>