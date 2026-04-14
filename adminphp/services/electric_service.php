<?php
session_start();
include '../db.php';

if (!isset($conn)) die("Connection not defined!");
if (!isset($_SESSION['user_id'])) {
    echo "يجب تسجيل الدخول للوصول لهذه الصفحة";
    exit;
}

$user_id = $_SESSION['user_id'];
$visaMasked = '';

$stmtCard = $conn->prepare("SELECT visa_number FROM users WHERE id = ?");
$stmtCard->bind_param("i", $user_id);
$stmtCard->execute();
$resCard = $stmtCard->get_result();

if ($resCard->num_rows > 0) {
    $visa = $resCard->fetch_assoc()['visa_number'];

    $first4 = substr($visa, 0, 4);
    $last4  = substr($visa, -4);

    $visaMasked = $first4 . " **** **** " . $last4;
}

// جلب فواتير الكهرباء
$sql = "SELECT * FROM bills WHERE user_id = ? AND bill_type = 'كهرباء' ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>دفع فاتورة الكهرباء</title>

    <style>
        /* ================= HEADER ================= */
        .header-section{
            height:80vh;
            background:url('../../assets/img/electric.jpg') center/cover no-repeat;
            position:relative;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .header-section::before{
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


        /* ================= PAYMENT SECTION ================= */
        .payment-section{
            padding:80px 20px;
            background:#f5f0e9;
        }


        /* CARD */
        .payment-card{
            max-width:950px;
            margin:auto;
            display:flex;
            background:#a4b5c4;
            border-radius:22px;
            overflow:hidden;
            box-shadow:0 25px 50px rgba(0,0,0,.25);
        }


        .payment-visual{
            position:relative;
            flex:1;
            background:#d9cbc2;
            color:#fff;
            padding:30px;

            display:flex;
            flex-direction:column;   /* 🔥 مهم */
            align-items:center;
            justify-content:center;
            gap:18px;                /* مسافة بين البطاقة والنص */
        }


        /* صورة الفيزا – كبرناها */
        .payment-visual img{
            width:100%;
            max-width:420px;        /* حجم بطاقة طبيعي */
            aspect-ratio: 1.586;   /* نسبة بطاقة Visa الحقيقية */
            object-fit: cover;
            border-radius:22px;
        }


        .visa-card-number{
            position:absolute;
            bottom:50%;
            left:50%;
            transform:translateX(-50%);
            z-index:2;

            font-size:21px;           /* أكبر */
            letter-spacing:5px;       /* مسافة بين الأرقام */
            font-weight:600;

            padding:12px 26px;
            border-radius:16px;

            background:rgba(0,0,0,0.35);
            backdrop-filter: blur(6px);

            color:#fff;
            font-family:'Courier New', monospace;
            direction:ltr;        /* 🔥 الحل */
            text-align:left;
            white-space:nowrap;
        }
        .payment-visual h4{color:#173b64;font-size:25px;margin-bottom:5px}
        .payment-visual p{color:#173b64;font-size:25px;opacity:.9;margin-top: 2px}

        /* RIGHT */
        .payment-form{
            flex:1;
            padding:40px;
        }
        .payment-form h3{
            text-align:center;
            font-size:24px;
            margin-bottom:30px;
        }

        /* FORM */
        .form-row{margin-bottom:18px}
        .form-row.two{
            display:flex;
            gap:15px;
        }
        .form-group{
            display:flex;
            flex-direction:column;
        }
        .form-group label{
            font-weight:600;
            margin-bottom:6px;
        }

        .payment-form input,
        .payment-form select{
            padding:12px;
            border-radius:10px;
            border:1px solid #ccc;
            font-size:15px;
            transition:.3s;
        }
        .payment-form input:focus,
        .payment-form select:focus{
            outline:none;
            border-color:#0d6efd;
            box-shadow:0 0 0 3px rgba(13,110,253,.2);
        }

        /* BUTTON */
        .pay-btn{
            width:100%;
            padding:14px;
            border-radius:30px;
            border:none;
            background:#8c6051;
            color:#fff;
            font-size:16px;
            cursor:pointer;
            transition:.3s;
        }
        .pay-btn:hover{
            transform:translateY(-2px);
            box-shadow:0 10px 25px rgba(0,0,0,.25);
        }

        #resultMsg{
            margin-top:15px;
            text-align:center;
            font-weight:bold;
        }

        /* ================= BILLS ================= */
        .bills-section{
            padding:60px 20px;
        }

        .bills-card{
            width:85%;
            margin:0 auto;
            background:#f1f4f8;
            padding:25px;
            border-radius:18px;
            box-shadow:0 12px 35px rgba(0,0,0,0.12);
        }

        .bills-table{
            width:100%;
            border-collapse:collapse;
            background:#ffffff;
            border-radius:14px;
            overflow:hidden;
        }

        .bills-table th,
        .bills-table td{
            font-size:22px;
            padding:14px;
            border:3px solid #e0e0e0;
            text-align:center;
        }

        .bills-table th{
            background:#a4b5c4;
            color:#fff;
        }

        .bills-table tr:hover{
            background:#eef3f9;
            transition:0.3s;
        }

        /* RESPONSIVE */
        @media(max-width:768px){
            .bills-card{
                width:100%;
                padding:15px;
            }

            .bills-table th,
            .bills-table td{
                font-size:16px;
                padding:10px;
            }
        }

    </style>
</head>

<body>

<!-- HEADER -->
<section class="header-section">
    <div class="header-content">
        <div class="header-glass">
            <h1>خدمة دفع فواتير الكهرباء</h1>
            <p style="font-size: 24px"> نوفر لك طريقة سهلة وآمنة لدفع فواتير الكهرباء دون عناء الانتظار أو التنقل.  </p>
            <p style="font-size: 24px">من خلال هذه الخدمة يمكنك اختيار المبلغ المناسب، إتمام عملية الدفع بسرعة، والاطلاع على سجل فواتيرك السابقة بكل شفافية.</p>
            <p style="font-size: 24px">هدفنا هو تبسيط تجربتك وتوفير وقتك مع أعلى معايير الأمان والموثوقية.</p>
        </div>
    </div>

</section>

<section class="payment-section">
    <div class="payment-card">

        <!-- LEFT -->
        <div class="payment-visual">
            <?php if($visaMasked): ?>
                <div class="visa-card-number">
                    <?= $visaMasked ?>
                </div>
            <?php endif; ?>

            <img src="../../assets/img/visa.jpeg" alt="Visa">

            <h4>الدفع الآمن</h4>
            <p>جميع العمليات مشفّرة وآمنة</p>
        </div>

        <!-- RIGHT -->
        <div class="payment-form">
            <h3>تفاصيل الدفع</h3>

            <form id="electricForm">
                <div class="form-row">
                    <div class="form-group">
                        <label>اسم صاحب البطاقة</label>
                        <input type="text" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>رقم البطاقة</label>
                        <input type="text" maxlength="20" inputmode="numeric" required>
                    </div>
                </div>

                <div class="form-row two">
                    <div class="form-group">
                        <label>تاريخ انتهاء البطاقة</label>
                        <input type="month" required>
                    </div>
                    <div class="form-group">
                        <label>CVV</label>
                        <input type="text" maxlength="3" inputmode="numeric" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>المبلغ</label>
                        <select id="amount" required>
                            <option value="" disabled selected>اختر المبلغ</option>
                            <option value="50">50 شيكل</option>
                            <option value="100">100 شيكل</option>
                            <option value="150">150 شيكل</option>
                            <option value="200">200 شيكل</option>
                            <option value="500">500 شبكل</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="pay-btn">ادفع الآن</button>
            </form>

            <div id="resultMsg"></div>
        </div>
    </div>
</section>

<section class="bills-section">
    <h2 style="text-align:center;margin-bottom:25px; color:#173b64">فواتير الكهرباء السابقة</h2>

    <?php if($result->num_rows > 0): ?>
    <div class="bills-card">
        <table class="bills-table">
            <tr>
                <th>رقم الفاتورة</th>
                <th>المبلغ</th>
                <th>التاريخ</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['total_amount'] ?> شيكل </td>
                    <td><?= $row['billing_date'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <?php else: ?>
        <p style="text-align:center">لا توجد فواتير</p>
    <?php endif; ?>
</section>

<script>
    document.getElementById("electricForm").addEventListener("submit",function(e){
        e.preventDefault();

        const amount = document.getElementById("amount").value;
        if(!amount){
            document.getElementById("resultMsg").innerText = "الرجاء اختيار مبلغ";
            return;
        }

        fetch("pay_electricity.php",{
            method:"POST",
            headers:{"Content-Type":"application/x-www-form-urlencoded"},
            body:"amount="+encodeURIComponent(amount)
        })
            .then(res=>res.json())
            .then(data=>{
                document.getElementById("resultMsg").innerText = data.message;
                if(data.success){
                    setTimeout(()=>location.reload(),1200);
                }
            });
    });
</script>

</body>
</html>