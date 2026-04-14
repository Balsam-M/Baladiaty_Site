<?php
session_start();
include 'db.php';
if (!isset($conn)) {
    die("Connection not defined!");
}

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendVerificationEmail($email, $code){
    $mail = new PHPMailer(true);
    try {
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 's12217816@stu.najah.edu';
        $mail->Password   = 'fkon whsy pyvy etdv';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('s12217816@stu.najah.edu', 'بوابة مدينتي', false);
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'كود التحقق لنسيت كلمة المرور';
        $mail->Body    = "<p>كود التحقق الخاص بك هو: <strong>$code</strong></p>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if(isset($_POST['action'])){
    header('Content-Type: application/json');
    $action = $_POST['action'];

    // خطوة 1: إرسال كود التحقق
    if($action == "send_code"){
        $email = $_POST['email'] ?? '';
        if(!$email){
            echo json_encode(['success'=>false, 'message'=>'يرجى إدخال البريد الإلكتروني']);
            exit;
        }

        $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            $userId = $row['id'];

            $code = rand(1000,9999);
            $_SESSION['fp_email'] = $email;
            $_SESSION['fp_id'] = $userId;
            $_SESSION['fp_code'] = $code;
            $_SESSION['fp_code_time'] = time();

            if(sendVerificationEmail($email, $code)){
                echo json_encode(['success'=>true, 'message'=>'تم إرسال كود التحقق إلى بريدك الإلكتروني.']);
            } else {
                echo json_encode(['success'=>false, 'message'=>'حدث خطأ أثناء إرسال البريد.']);
            }
        } else {
            echo json_encode(['success'=>false, 'message'=>'هذا البريد غير مسجل.']);
        }
        exit;
    }

    // خطوة 2: التحقق من الكود
    if($action == "verify_code"){
        $inputCode = $_POST['code'] ?? '';
        if(!isset($_SESSION['fp_code'])){
            echo json_encode(['success'=>false, 'message'=>'يرجى إعادة إرسال الكود.']);
            exit;
        }
        if($_SESSION['fp_code'] != $inputCode){
            echo json_encode(['success'=>false, 'message'=>'كود التحقق غير صحيح.']);
            exit;
        }
        echo json_encode(['success'=>true, 'message'=>'تم التحقق من الكود بنجاح.']);
        exit;
    }

    // خطوة 3: تحديث كلمة المرور باستخدام ID
    if($action == "reset_password"){
        $newPass = $_POST['newPass'] ?? '';
        if(!$newPass){
            echo json_encode(['success'=>false, 'message'=>'يرجى إدخال كلمة المرور الجديدة.']);
            exit;
        }

        if(!isset($_SESSION['fp_id'])){
            echo json_encode(['success'=>false, 'message'=>'يرجى بدء العملية من البداية.']);
            exit;
        }

        $userId = $_SESSION['fp_id'];
        $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        if(!$stmt){
            echo json_encode(['success'=>false, 'message'=>'خطأ في التحضير: '.$conn->error]);
            exit;
        }

        $stmt->bind_param("si", $hashedPass, $userId);
        if(!$stmt->execute()){
            echo json_encode(['success'=>false, 'message'=>'خطأ أثناء التنفيذ: '.$stmt->error]);
            exit;
        }

        unset($_SESSION['fp_email'], $_SESSION['fp_id'], $_SESSION['fp_code'], $_SESSION['fp_code_time']);
        echo json_encode(['success'=>true, 'message'=>'تم تحديث كلمة المرور بنجاح.']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نسيت كلمة المرور</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Tajawal', sans-serif;
            height: 100vh;
            background: #C8D9E6;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Wrapper */
        .fp-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Card */
        .fp-card {
            background: #fff;
            width: 92vw;
            height: 85vh;
            border-radius: 30px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.25);
            display: flex;
            overflow: hidden;
            animation: fadeUp 0.6s ease;
        }

        /* LEFT SIDE */
        .fp-left {
            width: 55%;
            background: #567c8d;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .fp-left img {
            width: 85%;
            max-height: 80%;
            object-fit: contain;
        }

        /* RIGHT SIDE */
        .fp-right {
            width: 45%;
            padding: 70px 60px;
            display: flex;
            background:#F5EFEB;
            flex-direction: column;
            justify-content: center;
        }

        /* Titles */
        .fp-title {
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 8px;
            text-align: right;
            color: #567c8d;
        }

        .fp-sub {
            font-size: 15px;
            color: #777;
            margin-bottom: 30px;
            text-align: right;
        }

        /* Inputs */
        .fp-input {
            width: 100%;
            padding: 14px;
            margin-bottom: 15px;
            border-radius: 14px;
            border: 1px solid #ddd;
            outline: none;
            font-size: 15px;
            text-align: right;
            transition: 0.3s;
        }

        .fp-input:focus {
            border-color: #1db7ae;
            box-shadow: 0 0 0 3px rgba(29,183,174,0.15);
        }

        /* Buttons */
        .fp-btn {
            width: 100%;
            padding: 14px;
            background: #ac6532;
            border: none;
            border-radius: 30px;
            color: white;
            font-size: 17px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .fp-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(29,183,174,0.4);
        }

        /* Code Inputs */
        .code-inputs {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 25px 0;
        }

        .code {
            width: 55px;
            height: 55px;
            font-size: 22px;
            text-align: center;
            border-radius: 14px;
            border: 1px solid #ddd;
            transition: 0.3s;
        }

        .code:focus {
            border-color: #1db7ae;
            box-shadow: 0 0 0 3px rgba(29,183,174,0.2);
        }

        /* Resend */
        .resend-text {
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }

        .resend-btn {
            background: none;
            border: none;
            color: #1db7ae;
            font-weight: 600;
            cursor: pointer;
        }

        /* Message */
        #fp-message {
            margin-top: 15px;
            font-weight: bold;
            text-align: center;
        }

        /* Animation */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 900px) {
            .fp-card {
                flex-direction: column;
                height: auto;
            }

            .fp-left {
                width: 100%;
                height: 280px;
            }

            .fp-left img {
                width: 70%;
            }

            .fp-right {
                width: 100%;
                padding: 40px;
            }
        }
    </style>


</head>

<body><div class="fp-card">

    <!-- LEFT : Illustration -->
    <div class="fp-left">
        <img src="../assets/img/forget.jpeg" alt="Forgot Password">
    </div>

    <!-- RIGHT : Form -->
    <div class="fp-right">

        <h2 class="fp-title">نسيت كلمة المرور؟</h2>
        <p class="fp-sub">أدخل بريدك الإلكتروني وسنرسل لك رمز التحقق</p>

        <div id="emailModule">
            <input type="email" id="fp-email" class="fp-input" placeholder="example@email.com">
            <button class="fp-btn" id="sendCodeBtn">إرسال كود التحقق</button>
        </div>

        <div id="codeModule" style="display:none;">
            <div class="code-inputs">
                <input type="text" maxlength="1" class="code">
                <input type="text" maxlength="1" class="code">
                <input type="text" maxlength="1" class="code">
                <input type="text" maxlength="1" class="code">
            </div>

            <button class="fp-btn" id="verifyCodeBtn">تحقق</button>

            <p class="resend-text">
                لم يصلك الكود؟
                <button class="resend-btn" id="resendBtn" disabled>إعادة إرسال (60s)</button>
            </p>
        </div>

        <div id="newPassModule" style="display:none;">
            <input type="password" id="newPassword" class="fp-input" placeholder="كلمة المرور الجديدة">
            <input type="password" id="confirmPassword" class="fp-input" placeholder="تأكيد كلمة المرور">
            <button class="fp-btn" id="resetPassBtn">حفظ</button>
        </div>

        <div id="fp-message"></div>

    </div>
</div>

</body>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    const emailModule = $('#emailModule');
    const codeModule = $('#codeModule');
    const newPassModule = $('#newPassModule');
    const fpMessage = $('#fp-message');

    const codeInputs = $('.code');

    codeInputs.on('input', function(){
        if(this.value.length>0){
            $(this).next('input').focus();
        }
    });

    let countdown = 60;
    let interval;

    function startCountdown(){
        $('#resendBtn').prop('disabled', true).text(`إعادة إرسال (${countdown}s)`);
        interval = setInterval(()=>{
            countdown--;
            $('#resendBtn').text(`إعادة إرسال (${countdown}s)`);
            if(countdown<=0){
                clearInterval(interval);
                $('#resendBtn').prop('disabled', false).text('إعادة إرسال');
                countdown=60;
            }
        },1000);
    }

    $('#sendCodeBtn').click(()=>{
        let email = $('#fp-email').val().trim();
        if(!email){ fpMessage.text('يرجى إدخال البريد الإلكتروني'); return; }

        $.post('forgot_password.php', {action:'send_code', email:email}, function(res){
            fpMessage.css('color', res.success?'green':'red').text(res.message);
            if(res.success){
                emailModule.hide();
                codeModule.show();
                codeInputs.first().focus();
                startCountdown();
            }
        }, 'json');
    });

    $('#verifyCodeBtn').click(()=>{
        let code = '';
        codeInputs.each(function(){ code += $(this).val(); });
        if(code.length!=4){ fpMessage.css('color','red').text('أدخل كود من 4 خانات'); return; }

        $.post('forgot_password.php', {action:'verify_code', code:code}, function(res){
            fpMessage.css('color', res.success?'green':'red').text(res.message);
            if(res.success){
                codeModule.hide();
                newPassModule.show();
            }
        }, 'json');
    });

    $('#resendBtn').click(()=>{
        $('#sendCodeBtn').click();
    });

    $('#resetPassBtn').click(()=>{
        let newPass = $('#newPassword').val();
        let confirmPass = $('#confirmPassword').val();
        if(!newPass || !confirmPass){ fpMessage.css('color','red').text('يرجى تعبئة الحقول'); return; }
        if(newPass!==confirmPass){ fpMessage.css('color','red').text('كلمة المرور غير متطابقة'); return; }

        $.post('forgot_password.php', {action:'reset_password', newPass:newPass}, function(res){
            fpMessage.css('color', res.success?'green':'red').text(res.message);
            if(res.success){
                setTimeout(()=>{ window.location.href='../index.html'; },1500);
            }
        }, 'json');
    });
</script>

</body>
</html>
