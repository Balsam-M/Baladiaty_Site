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
    <title>طلب معاملة رسمية</title>

    <style>
        /* ===== HEADER ===== */
        .header{
            height:80vh; /* أطول */
            background:url('../../assets/img/official.jpeg') center/cover no-repeat;
            position:relative;
            display:flex;
            align-items:center;
            justify-content:center;
            margin-bottom:-140px; /* 🔥 يركب على السكشن الثاني */
        }

        .header::before{
            content:"";
            position:absolute;
            inset:0;
            background:rgba(0,0,0,.55);
        }

        .header-content{
            position:relative;
            color:#fff;
            text-align:center;
            max-width:850px;
            animation:fadeDown 1.2s ease;
        }

        .header-content h1{
            font-size:54px;
            margin-bottom:18px;
        }

        .header-content p{
            font-size:36px;
            line-height:1.8;
        }

        @keyframes fadeDown{
            from{opacity:0;transform:translateY(-30px)}
            to{opacity:1;transform:translateY(0)}
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
        /* ===== FORM SECTION ===== */
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
        <h1>خدمة طلب المعاملات الرسمية</h1>
        <p>
            قدّم طلبك بسهولة عبر الإنترنت، اختر نوع المعاملة واملأ البيانات المطلوبة
            وسيتم مراجعتها من قبل الجهة المختصة.
        </p>
    </div>
</section>

<!-- TYPES -->
<section class="types-section">
    <div class="types-grid">

        <div class="type-card" id="group-one" onclick="openForm('معاملات البناء والتنظيم', building)">
            <span>🏠</span>
            <h4>البناء والتنظيم</h4>
        </div>

        <div class="type-card" id="group-two" onclick="openForm('المعاملات المالية', financial)">
            <span>🧾</span>
            <h4>المعاملات المالية</h4>
        </div>

        <div class="type-card" id="group-three" onclick="openForm('إفادات وشهادات', certificates)">
            <span>📜</span>
            <h4>إفادات وشهادات</h4>
        </div>

        <div class="type-card" id="group-one" onclick="openForm('المحلات والمهن', shops)">
            <span>🏪</span>
            <h4>المحلات والمهن</h4>
        </div>

        <div class="type-card" id="group-two" onclick="openForm('الخدمات العامة', services)">
            <span>🌳</span>
            <h4>الخدمات العامة</h4>
        </div>

        <div class="type-card" id="group-three" onclick="openForm('معاملات أخرى', others)">
            <span>🚗</span>
            <h4>معاملات أخرى</h4>
        </div>

    </div>
</section>

<!-- FORM -->
<section class="form-section" id="formSection">
    <div class="form-box">
        <h3 id="formTitle" ></h3>

        <form id="requestForm">
            <input type="hidden" name="document_type" id="document_type">

            <label style="font-size: 32px; color:#2f4156"  >نوع الطلب</label>
            <select name="details" id="detailsSelect" required></select>

            <label style="font-size: 32px;color:#2f4156">ملاحظات</label>
            <textarea name="notes" placeholder="اكتب أي تفاصيل إضافية..."></textarea>

            <button type="submit" class="submit-btn">إرسال الطلب</button>
        </form>

        <div id="resultMsg"></div>
    </div>
</section>

<script>
    const building = [
        "رخصة بناء","ترخيص ترميم","مخطط تنظيمي","إفادة مساحة",
        "رخصة هدم","إفادة إشغال"
    ];
    const financial = [
        "دفع ضريبة الأملاك","دفع رسوم النفايات","تسوية متأخرات",
        "براءة ذمة","تقسيط رسوم"
    ];
    const certificates = [
        "إفادة سكن","عدم محكومية بلدية","إفادة ملكية",
        "عدم ممانعة","تغيير اسم شارع"
    ];
    const shops = [
        "ترخيص محل","تجديد رخصة","تغيير نشاط",
        "إغلاق محل","نقل ملكية"
    ];
    const services = [
        "طلب حاوية نفايات",
        "تعبيد شارع",
        "تنظيف الحدائق العامة",
        "إصلاح أعمدة الإنارة",
        "صيانة الأرصفة",
        "تشجير وزراعة أشجار"
    ];

    const others = [
        "ترخيص مظلة","حجز موقف","ترقيم منزل",
        "تغيير رقم بناء",
    ];

    function openForm(type, list){
        document.getElementById("formSection").style.display="block";
        document.getElementById("formTitle").innerText = type;
        document.getElementById("document_type").value = type;

        const select = document.getElementById("detailsSelect");
        select.innerHTML="";
        list.forEach(item=>{
            select.innerHTML += `<option value="${item}">${item}</option>`;
        });
    }

    document.getElementById("requestForm").addEventListener("submit",function(e){
        e.preventDefault();
        fetch("submit_request.php",{
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