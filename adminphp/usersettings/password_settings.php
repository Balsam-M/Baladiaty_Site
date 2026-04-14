<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تغيير كلمة المرور</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <style>
        body{
            font-family:Cairo;
            background:#f5f0e9;
        }
        .box{
            max-width:500px;
            margin:80px auto;
            background:#fff;
            padding:40px;
            border-radius:20px;
            box-shadow:0 15px 40px rgba(0,0,0,.2);
        }
        label{font-weight:bold}
        input{
            width:100%;
            padding:14px;
            margin:10px 0 20px;
            border-radius:10px;
            border:1px solid #ccc;
        }
        button{
            background:#567c8d;
            color:#fff;
            padding:14px 30px;
            border:none;
            border-radius:12px;
            cursor:pointer;
        }
    </style>
</head>
<body>

<div class="box">
    <h3>🔐 تغيير كلمة المرور</h3>

    <input type="password" id="oldPass" placeholder="كلمة المرور الحالية">
    <input type="password" id="newPass" placeholder="كلمة المرور الجديدة">
    <input type="password" id="confirmPass" placeholder="تأكيد كلمة المرور">

    <button onclick="changePassword()">حفظ</button>
</div>

<script>
    function changePassword(){
        let fd = new FormData();
        fd.append("old",oldPass.value);
        fd.append("new",newPass.value);
        fd.append("confirm",confirmPass.value);

        fetch("update_password.php",{method:"POST",body:fd})
            .then(r=>r.text())
            .then(alert);
    }
</script>

</body>
</html>
