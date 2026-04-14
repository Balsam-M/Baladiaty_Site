<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    echo "يجب تسجيل الدخول";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقديم شكوى</title>

    <style>
        body{
            margin:0;
            font-family: Arial, sans-serif;
            background:#f5f0e9;
        }

        /* ===== HEADER ===== */
        .header{
            height:80vh;
            background:url('../../assets/img/complaint.jpg') center/cover no-repeat;
            position:relative;
            display:flex;
            align-items:center;
            justify-content:center;
            margin-bottom:-120px;
        }

        .header::before{
            content:"";
            position:absolute;
            inset:0;
            background:rgba(0,0,0,.6);
        }

        .header-content{
            position:relative;
            color:#fff;
            text-align:center;
            max-width:750px;
        }

        .header-content h1{
            font-size:54px;
            margin-bottom:20px;
        }

        .header-content p{
            font-size:32px;
            line-height:1.7;
        }

        /* ===== GROUP COLORS ===== */

        /* المجموعة الأولى */
        #group-one{
            background:#B3C8CF;   /* أخضر مائل للبلدي */
        }

        #group-one:hover{
            background:#B3C8CF;
        }

        /* المجموعة الثانية */
        #group-two{
            background:#94b4c1;   /* بني دافئ */
        }

        #group-two:hover{
            background:#94b4c1;
        }
        #group-three{
            background: #567c8d;
        }
        #group-three :hover{
            background: #567c8d;
        }

        /* ===== TYPES ===== */
        .types-section{
            padding:100px 20px 100px;/* مسافة أكبر من فوق */
            margin-top:90px;
            background:#f5f0e9;
        }

        .types-grid{
            display:grid;
            grid-template-columns:repeat(3, 1fr); /* 🔥 3 مربعات بالصف */
            gap:70px;                              /* مسافة بينهم */
            max-width:1000px;
            margin:0 auto;                        /* توسيط */
        }

        .type-card{
            color:#fff;
            padding:18px 15px;   /* أقل */
            min-height:120px;    /* ثابته وأصغر */
            border-radius:26px;
            text-align:center;
            cursor:pointer;
            transition:.35s ease;
            font-size:18px;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
        }

        .type-card span{
            font-size:32px;           /* 🔥 أيقونة أوضح */
            margin-bottom:7px;
        }

        .type-card h4{
            font-size:26px;
            font-weight:600;
        }


        /* Hover */
        .type-card:hover{
            transform:translateY(-10px);
            box-shadow:0 30px 55px rgba(0,0,0,.2);
            background:#567c8d;
            color:#fff;
        }

        /* خط ديكوري */
        .type-card::after{
            content:"";
            width:40px;
            height:4px;
            background:#f5f0e9;
            display:block;
            margin:20px auto 0;
            border-radius:10px;
            transition:.3s;
        }

        .type-card:hover::after{
            width:70px;
            background:#fff;
        }
        @media(max-width:900px){
            .types-grid{
                grid-template-columns:repeat(2,1fr);
            }
        }

        @media(max-width:600px){
            .types-grid{
                grid-template-columns:1fr;
            }
        }
        /* ===== FORM ===== */
        .form-section{
            padding:35px 20px;
            background:#e3edf1; /* لون فاتح يتناسق مع السكشن الثاني */
            display:none;
            border-top: 5px solid #B3C8CF; /* يعطي تواصل بصري مع المجموعة الأولى */
        }

        .form-box{
            max-width:550px;
            margin:auto;
            background:#fff;
            padding:45px 40px;
            border-radius:26px;
            box-shadow:0 15px 35px rgba(0,0,0,0.1);
            border-top:5px solid #567c8d; /* لون يربط بالسكشن الثاني */
            transition:.3s ease;
        }

        .form-box:hover{
            box-shadow:0 25px 45px rgba(0,0,0,0.15);
        }

        .form-box h3{
            text-align:center;
            margin-bottom:30px;
            font-size:36px;
            color:#567c8d; /* نفس لون الخط الرئيسي للسكشن الثاني */
        }

        .form-box label{
            font-weight:700;
            margin-top:20px;
            display:block;
            color:#333;
        }
        .form-box select,
        .form-box textarea{
            width:100%;       /* أصغر من 100% */
            padding:14px;
            margin-top:10px;
            border-radius:12px;
            border:1px solid #ccc;
            font-size:25px;  /* تكبير الخط */
            display:block;
            margin-left:auto;
            margin-right:auto; /* توسيط الحقل */
        }


        .form-box textarea{
            height:140px;
            resize:none;
        }

        .submit-btn{
            width:100%;
            margin-top:30px;
            padding:16px;
            border:2px;
            border-radius:30px;
            background:#8c6051; /* نفس اللون الأساسي للسكشن الثاني */
            color:#fff;
            font-size:28px;
            cursor:pointer;
            transition:.3s ease;
        }

        .submit-btn:hover{
            background:#8c6051;
        }

        #resultMsg{
            text-align:center;
            margin-top:18px;
            font-weight:bold;
            font-size:22px;
            color:#567c8d; /* متناسق مع اللون الأساسي */
        }
    </style>
</head>

<body>

<!-- HEADER -->
<section class="header">
    <div class="header-content">
        <h1>خدمة الشكاوى</h1>
        <p>
            نسعد باستقبال شكاواكم والعمل على متابعتها لضمان تحسين جودة الخدمات المقدّمة. تهدف هذه الخدمة إلى الاستماع لملاحظاتكم ومعالجة الشكاوى بكل شفافية وبما يخدم المصلحة العامة.
        </p>
    </div>
</section>

<!-- TYPES -->
<section class="types-section">
    <div class="types-grid">

        <div class="type-card"  id="group-one" onclick="openForm(' شكاوى البنية التحتية', infrastructure)">
            <span>🚧</span>
            <h4>البنية التحتية</h4>
        </div>

        <div class="type-card"  id="group-two" onclick="openForm(' شكاوى الإنارة والكهرباء', lighting)">
            <span>💡</span>
            <h4>الإنارة والكهرباء</h4>
        </div>

        <div class="type-card"  id="group-three" onclick="openForm('️ شكاوى النظافة', cleaning)">
            <span>🗑️</span>
            <h4>النظافة</h4>
        </div>

        <div class="type-card"  id="group-one" onclick="openForm(' شكاوى المرور والسلامة', traffic)">
            <span>🚦</span>
            <h4>المرور والسلامة</h4>
        </div>

        <div class="type-card"  id="group-two" onclick="openForm('️ شكاوى الأحياء', neighborhoods)">
            <span>🏘️</span>
            <h4>الأحياء</h4>
        </div>

        <div class="type-card" id="group-three" onclick="openForm(' شكاوى إدارية', admin)">
            <span>🧾</span>
            <h4>إدارية</h4>
        </div>

    </div>
</section>

<!-- FORM -->
<section class="form-section" id="formSection">
    <div class="form-box">
        <h3 id="formTitle"></h3>

        <form id="complaintForm">
            <input type="hidden" name="title" id="complaintTitle">

            <label>نوع الشكوى</label>
            <select name="description" id="detailsSelect" required></select>

            <label>تفاصيل إضافية</label>
            <textarea name="notes" placeholder="اشرح المشكلة إن وُجد..."></textarea>

            <button type="submit" class="submit-btn">إرسال الشكوى</button>
        </form>

        <div id="resultMsg"></div>
    </div>
</section>

<script>
    const infrastructure = [
        "شارع محفّر","أرصفة تالفة","حفريات غير مكتملة",
        "تجمع مياه","تصريف مياه الأمطار"
    ];

    const lighting = [
        "إنارة شارع معطّلة","أعمدة إنارة تالفة",
        "ضعف إنارة في حي","أسلاك مكشوفة"
    ];

    const cleaning = [
        "تراكم نفايات","حاوية نفايات تالفة",
        "تأخر جمع النفايات","رمي نفايات عشوائي",
        "مخلفات بناء"
    ];

    const traffic = [
        "غياب إشارات مرورية","ازدحام مروري",
        "سرعة زائدة","نقص مطبات",
        "مواقف سيارات عشوائية"
    ];

    const neighborhoods = [
        "إزعاج وضجيج","اعتداء على ممتلكات عامة",
        "بناء مخالف","احتلال رصيف",
        "تشويه منظر عام"
    ];

    const admin = [
        "تأخير معاملة","سوء معاملة",
        "خطأ في رسوم","مشكلة في خدمة إلكترونية",
        "صعوبة حجز موعد"
    ];

    function openForm(title, list){
        document.getElementById("formSection").style.display = "block";
        document.getElementById("formTitle").innerText = title;
        document.getElementById("complaintTitle").value = title;

        const select = document.getElementById("detailsSelect");
        select.innerHTML = "";
        list.forEach(item=>{
            select.innerHTML += `<option value="${item}">${item}</option>`;
        });
    }

    document.getElementById("complaintForm").addEventListener("submit",function(e){
        e.preventDefault();
        fetch("submit_complaint.php",{
            method:"POST",
            body:new FormData(this)
        })
            .then(res=>res.json())
            .then(data=>{
                document.getElementById("resultMsg").innerText = data.message;
                if(data.success) this.reset();
            });
    });
</script>

</body>
</html>
