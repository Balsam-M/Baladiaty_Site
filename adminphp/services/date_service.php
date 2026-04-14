<?php
session_start();
if(!isset($_SESSION['user_id'])){
    echo "يجب تسجيل الدخول";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>حجز موعد</title>

    <style>
        body{
            margin:0;
            font-family: "Cairo", sans-serif;
            background:#f5f0e9;
        }

        /* ===== HEADER ===== */
        .header{
            height:80vh;
            background:url('../../assets/img/appointment.jpeg') center/cover no-repeat;
            position:relative;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .header::before{
            content:"";
            position:absolute;
            inset:0;
            background:rgba(0,0,0,.35);
        }
        .header-content{
            position:relative;
            z-index:2;
            color:#fff;
            text-align:center;
            max-width:700px;
            animation:fadeDown 1.2s ease;
        }
        @keyframes fadeDown{
            from{opacity:0;transform:translateY(-30px)}
            to{opacity:1;transform:translateY(0)}
        }
        .header-content h1{font-size:48px;margin-bottom:15px}
        .header-content p{font-size:20px}

        .header-glass{
            background: rgba(0, 0, 0, 0.35); /* شفافية */
            backdrop-filter: blur(4px);      /* تأثير زجاج */
            padding: 35px 60px;              /* أكبر من العنوان */
            border-radius: 22px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.35);
            display: inline-block;
        }

        .header-glass h1{
            font-size:48px;
            margin-bottom:15px;
            color:#fff;
        }

        .header-glass p{
            font-size:20px;
            color:#f1f1f1;
        }

        /* ===== FORM ===== */
        .form-section{
            margin-top:20px;
            padding:60px 20px;


        }

        .form-box{
            max-width:600px;
            background:#fff;
            border-top:8px solid #d2691e; /* لون يربط بالسكشن الثاني */
            transition:.3s ease;
            margin:auto;
            padding:45px;
            border-radius:26px;
            box-shadow:0 20px 45px rgba(0,0,0,.15);
        }
        .form-box:hover{
            box-shadow:0 25px 45px rgba(0,0,0,0.15);
        }

        .form-box h3{
            text-align:center;
            font-size:34px;
            color:#567c8d;
            margin-bottom:30px;
        }

        label{
            font-weight:bold;
            display:block;
            margin-top:20px;
        }

        input{
            width:100%;
            padding:14px;
            margin-top:10px;
            border-radius:12px;
            border:1px solid #ccc;
            font-size:20px;
        }

        /* ===== TIME SLOTS ===== */
        .time-slots{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:15px;
            margin-top:25px;
        }

        .slot{
            padding:15px;
            border-radius:16px;
            background:#B3C8CF;
            color:#fff;
            text-align:center;
            cursor:pointer;
            font-size:20px;
            transition:.3s;
        }

        .slot:hover{
            background:#d2691e;
        }

        .slot.active{
            background:#d2691e;
        }

        .slot.full{
            background:#c0392b;
            cursor:not-allowed;
        }

        .submit-btn{
            margin-top:35px;
            width:100%;
            padding:16px;
            font-size:26px;
            border:none;
            border-radius:30px;
            background:#d2691e;
            color:#fff;
            cursor:pointer;
        }
    </style>
</head>

<body>

<section class="header">
    <div class="header-content">
        <div class="header-glass">
        <h1>حجز موعد في البلدية</h1>
        <p>احجز موعدك بسهولة واختر الوقت المناسب لك دون ازدحام</p>
    </div>
    </div>
</section>

<section class="form-section">
    <div class="form-box">
        <h3>بيانات لحجز موعد </h3>

        <label>نوع الخدمة</label>
        <input type="text" id="serviceType" >

        <label>التاريخ</label>
        <input type="date" id="appointmentDate">

        <label>اختر الساعة</label>
        <div class="time-slots" id="timeSlots"></div>

        <button class="submit-btn" onclick="saveAppointment()">تأكيد الحجز</button>
    </div>
</section>

<script>
    const hours = ["09:00","10:00","11:00","12:00","13:00","14:00"];
    let selectedTime = "";

    /* إنشاء الساعات */
    hours.forEach(h=>{
        const div = document.createElement("div");
        div.className="slot";
        div.innerText=h;
        div.onclick=()=>{
            if(div.classList.contains("full")) return;
            document.querySelectorAll('.slot').forEach(s=>s.classList.remove("active"));
            div.classList.add("active");
            selectedTime=h;
        }
        document.getElementById("timeSlots").appendChild(div);
    });

    /* حفظ الموعد */
    function saveAppointment(){
        const date = document.getElementById("appointmentDate").value;
        const service = document.getElementById("serviceType").value;

        if(!date || !selectedTime || !service){
            alert("يرجى تعبئة جميع الحقول");
            return;
        }

        const fd = new FormData();
        fd.append("appointment_date",date);
        fd.append("appointment_time",selectedTime);
        fd.append("service_type",service);

        fetch("save_appointment.php",{
            method:"POST",
            body:fd
        })
            .then(res=>res.json())
            .then(data=>{
                alert(data.message);
                if(data.success) location.reload();
            });
    }
</script>

</body>
</html>