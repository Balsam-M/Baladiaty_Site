<?php
include 'db.php';

// التأكد من وجود الاتصال
if (!isset($conn)) {
    die("Connection not defined!");
}

// استقبال البيانات من AJAX أو الفورم
$id           = $_POST['id'];
$full_name    = $_POST['full_name'];
$email        = $_POST['email'];
$password     = $_POST['password'];
$phone        = $_POST['phone'];
$date_of_birth= $_POST['date_of_birth'];
$city         = $_POST['city'];
$street       = $_POST['street'];
$visa_number  = $_POST['visa_number'];

// بناء جملة الـ UPDATE
if (empty($password)) {
    // لو الباسوورد لم يتغير، لا نعدله
    $sql = "UPDATE users SET 
                full_name = '$full_name', 
                email = '$email', 
                phone = '$phone', 
                date_of_birth = '$date_of_birth', 
                city = '$city', 
                street = '$street', 
                visa_number = '$visa_number' 
            WHERE id = '$id'";
} else {
    // لو المستخدم عدل كلمة السر
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET 
                full_name = '$full_name', 
                email = '$email', 
                password = '$hashed_password', 
                phone = '$phone', 
                date_of_birth = '$date_of_birth', 
                city = '$city', 
                street = '$street', 
                visa_number = '$visa_number' 
            WHERE id = '$id'";
}

// تنفيذ الاستعلام
if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}
?>