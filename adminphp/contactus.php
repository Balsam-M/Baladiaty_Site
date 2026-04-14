<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// إعداد البريد المستلم
$to = "Fawzia.y123456@gmail.com";

// التحقق من POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "طريقة الطلب غير مسموحة"]);
    exit;
}

// جلب بيانات الفورم
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo json_encode(["success" => false, "message" => "الرجاء تعبئة جميع الحقول"]);
    exit;
}

// تهيئة PHPMailer
$mail = new PHPMailer(true);

try {
    // إعدادات SMTP Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 's12217816@stu.najah.edu'; // حساب البلدية
    $mail->Password   = 'fkon whsy pyvy etdv'; // كلمة مرور التطبيق
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // المرسل والرد
    $mail->setFrom('s12217816@stu.najah.edu', 'بوابة مدينتي'); // إيميل البلدية دائمًا
    $mail->addAddress($to);
    $mail->addReplyTo($email, $name); // إيميل المستخدم للرد

    // قبل send()
    $mail->CharSet = 'UTF-8';           // ترميز الرسالة
    $mail->setFrom('s12217816@stu.najah.edu', 'بوابة مدينتي'); // اسم المرسل
    $mail->addReplyTo($email, $name);    // اسم المستخدم للرد
    $mail->isHTML(false);                 // لو الرسالة نصية فقط

    $mail->Subject = $subject;           // الموضوع بالعربي
    $mail->Body    = "الاسم: $name\nالبريد الإلكتروني: $email\n\nرسالة:\n$message";

    $mail->send();
    echo json_encode(["success" => true, "message" => "تم إرسال رسالتك بنجاح!"]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "حدث خطأ أثناء الإرسال: {$mail->ErrorInfo}"]);
}
?>