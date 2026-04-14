<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}
$userName = $_SESSION['user_name'] ?? 'المستخدم';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إعدادات المستخدم</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

<div class="container">

    <!-- ===== Sidebar ===== -->
    <aside class="sidebar">
        <div class="profile">
            <!-- صورة الأيقونة -->
            <img src="../../assets/img/usericon.png" alt="صورة المستخدم" class="profile-img">

            <!-- الاسم -->
            <h3 id="userName"><?= htmlspecialchars($userName) ?></h3>
        </div>

        <ul class="menu">
            <li class="active">المعلومات الشخصية</li>
            <li>تغيير كلمة المرور</li>
            <li onclick="location.href='../userpage.php'">تسجيل الخروج</li>
        </ul>
    </aside>

    <!-- ===== Content ===== -->
    <main class="content">

        <div class="user-settings-form">
            <h3>إعدادات الحساب</h3>

            <form id="userForm">

                <div class="form-row">
                    <label>الاسم الكامل
                        <input type="text" name="full_name" id="full_name">
                    </label>

                    <label>البريد الإلكتروني
                        <input type="email" name="email" id="email">
                    </label>
                </div>

                <div class="form-row">
                    <label>رقم الهاتف
                        <input type="text" name="phone" id="phone">
                    </label>

                    <label>المدينة
                        <input type="text" name="city" id="city">
                    </label>
                </div>

                <div class="form-row">
                    <label>الشارع
                        <input type="text" name="street" id="street">
                    </label>

                    <label>رقم بطاقة الفيزا
                        <input type="text" name="visa_number" id="visa_number">
                    </label>
                </div>

                <div class="form-buttons">
                    <button type="button" class="cancel" id="cancelBtn">❌ إلغاء التعديلات</button>
                    <button class="save">💾 حفظ التعديلات</button>
                </div>

            </form>
        </div>

    </main>
</div>
<!-- ===== Password Modal ===== -->
<div id="passwordModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>🔐 تغيير كلمة المرور</h3>
        <input type="password" id="newPass" placeholder="كلمة المرور الجديدة">
        <input type="password" id="confirmPass" placeholder="تأكيد كلمة المرور">
        <button id="savePassBtn">💾 حفظ</button>
        <div id="passMsg" style="margin-top:10px;color:red;"></div>
    </div>
</div>


<!-- ===== CSS ===== -->
<style>
    body{
        margin:0;
        font-family:"Cairo",sans-serif;
        background:#f5f0e9;
    }

    .container{display:flex}

    .sidebar{
        width:260px;
        background:#c8d9e6;
        color:#000000;
        min-height:100vh;
    }

    .profile{text-align:center;padding:40px 20px}

    .menu{list-style:none;padding:0}
    .menu li{
        padding:18px 30px;
        cursor:pointer;
    }
    .menu li.active,
    .menu li:hover{background:#ffe9ef}

    .content{
        flex:1;
        padding:40px;
    }

    .user-settings-form{
        background:rgba(255,255,255,.9) url('../../assets/img/userset3.jpeg') center/cover;
        border-radius:20px;
        padding:40px;
        min-height:700px;
        max-width: 1200px;          /* عرض أصغر */
        margin: auto;
        box-shadow:0 20px 60px rgba(0,0,0,.2);
    }
    /* عند التركيز يصبح الحد أزرق */
    input:focus {
        border-color: #0a5d7a;
        outline: none;
    }
    .user-settings-form h3{
        margin-bottom:40px;
        color:#0a5d7a;
    }

    .form-row{
        display:flex;
        gap:70px;
        margin-bottom:25px;
    }

    label{
        flex:1;
        font-weight:bold;
        color:#0a5d7a;
    }

    input{
        width:90%;
        padding:16px;
        border-radius:12px;
        border:1px solid #ccc;
        margin-top:8px;
        font-size:18px;
    }

    .form-buttons{
        display:flex;
        justify-content:center;
        gap:25px;
        margin-top:40px;

    }

    .save{
        background:#567c8d;
        color:#fff;
        border:none;
        padding:15px 40px;
        border-radius:14px;
        cursor:pointer;
        font-size: 24px;
    }

    .cancel{
        background:#eee;
        border:1px solid #ccc;
        padding:15px 40px;
        border-radius:14px;
        cursor:pointer;
    }

    /* ===== Password Modal CSS ===== */
    .modal {
        display: none;
        position: fixed;
        z-index: 999;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: #f6f3ec;
        padding: 30px;
        border-radius: 20px;
        max-width: 400px;
        width: 90%;
        text-align: center;
        position: relative;
    }

    .modal-content h3 {
        color: #3e5f6d; /* اللون الأزرق للعنوان */
        margin-bottom: 20px;
    }

    .modal-content input{
        width: 90%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 10px;
        border: 1px solid #ccc;
        transition: border 0.3s ease; /* ترانزيشن للحد */
    }

    /* عند التركيز على الحقل يصبح الحد أزرق */
    .modal-content input:focus{
        border-color: #0a5d7a;
        outline: none;
    }

    .modal-content button{
        background: #567c8d;
        color: #fff;
        padding: 12px 25px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease; /* ترانزيشن للزر */
    }

    /* تأثير الهوفير على الزر */
    .modal-content button:hover{
        background-color: #3e5f6d; /* لون أغمق عند المرور */
        transform: scale(1.05);    /* تكبير خفيف */
    }

    .modal-content .close{
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
    }

    /* الأزرار الرئيسية */
    .save, .cancel {
        padding: 20px 50px;  /* حجم أكبر */
        font-size: 24px;
        border-radius: 16px;
        transition: all 0.3s ease; /* إضافة ترانزيشن */
    }

    /* تأثير الهوفير */
    .save:hover {
        background-color: #ffe9ef; /* لون أغمق عند المرور */
        transform: scale(1.05);/* تكبير بسيط */
        color:#000000;
    }

    .cancel:hover {
        background-color: #c8d9e6;    /* لون أخف عند المرور */
        transform: scale(1.05);    /* تكبير بسيط */
        color:#ffffff;
    }

    /* زر حفظ كلمة المرور بالمودال */
    .modal-content button {
        padding: 18px 40px;  /* زيادة الحجم */
        font-size: 18px;     /* تكبير الخط */
        border-radius: 12px;
    }
    .profile-img {
        width: 80px;       /* عرض متوسط */
        height: 80px;      /* ارتفاع متوسط */
        border-radius: 50%; /* دائرة كاملة */
        margin-bottom: 10px;
        object-fit: cover;  /* لتجنب التشوه */
        border: 2px solid #fff; /* حد أبيض بسيط */
    }

</style>

<!-- ===== JS ===== -->
<script>
    const userForm = document.getElementById("userForm");
    let originalData = {};

    fetch('get_user.php')
        .then(r=>r.json())
        .then(d=>{
            originalData = d;
            for(let k in d){
                if(document.getElementById(k))
                    document.getElementById(k).value = d[k];
            }
            document.getElementById("userName").innerText = d.full_name;
        });

    userForm.onsubmit = e =>{
        e.preventDefault();
        let changed = false;
        for(let k in originalData){
            if(document.getElementById(k).value !== originalData[k]){
                changed = true; break;
            }
        }
        if(!changed) { alert("لم يتم تعديل أي قيمة"); return; }

        fetch('update_user.php',{
            method:"POST",
            body:new FormData(userForm)
        })
            .then(r=>r.json())
            .then(r=>{
                if(r.status==="success"){
                    alert("✅ تم حفظ التعديلات");
                    originalData = Object.fromEntries(new FormData(userForm));
                    userName.innerText = full_name.value;
                } else alert("❌ حدث خطأ");
            });
    };

    cancelBtn.onclick = ()=>{
        for(let k in originalData){
            if(document.getElementById(k))
                document.getElementById(k).value = originalData[k];
        }
    };

    const passwordModal = document.getElementById("passwordModal");
    const passMsg = document.getElementById("passMsg");

    document.querySelector(".menu li:nth-child(2)").onclick = () => {
        passwordModal.style.display = "flex";
    };

    document.querySelector(".modal .close").onclick = () => {
        passwordModal.style.display = "none";
        passMsg.innerText = "";
    };

    document.getElementById("savePassBtn").onclick = () => {
        const newPassword = newPass.value;
        const confirmPassword = confirmPass.value;

        if(newPassword !== confirmPassword){
            passMsg.innerText = "❌ كلمة المرور غير متطابقة";
            return;
        }
        if(newPassword.length < 6){
            passMsg.innerText = "❌ كلمة المرور يجب أن تكون 6 أحرف على الأقل";
            return;
        }

        let fd = new FormData();
        fd.append("new", newPassword);
        fd.append("confirm", confirmPassword);

        fetch("update_password.php",{method:"POST", body:fd})
            .then(r=>r.text())
            .then(msg=>{
                passMsg.innerText = msg;
                if(msg.includes("✅")){
                    newPass.value = confirmPass.value = "";
                }
            });
    };

    window.onclick = e => {
        if(e.target == passwordModal){
            passwordModal.style.display = "none";
            passMsg.innerText = "";
        }
    };

</script>

</body>
</html>
