<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

$full_name = $_SESSION['full_name'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>user page</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&amp;display=swap" rel="stylesheet" />

    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/style2.css" rel="stylesheet" />
    <link href="../css/user.css" rel="stylesheet" />

    <link rel="stylesheet" href="../css/chatbot.css">

</head>
<body>


<!-- Background Video-->
<video class="bg-video" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop"><source src="../assets/mp4/bg.mp4" type="video/mp4" /></video>



<!-- Contact Icons -->
<div class="social-icons">
    <div class="d-flex flex-row flex-lg-column justify-content-center align-items-center h-100 mt-3 mt-lg-0">

        <!-- Facebook -->
        <a class="btn btn-dark m-3" href="https://www.facebook.com/share/1BvDbCn5mT/" target="_blank">
            <i class="fab fa-facebook-f"></i>
        </a>

        <!-- Phone -->
        <a class="btn btn-dark m-3" href="tel:+970594374249">
            <i class="fas fa-phone-alt"></i>
        </a>

        <!-- Email -->
        <a class="btn btn-dark m-3" href="mailto: balsamadnanmashaqi@gmail.com">
            <i class="fas fa-envelope"></i>
        </a>

    </div>

</div>



<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
    <div class="container px-4 px-lg-5 d-flex justify-content-between align-items-center">
        <!-- روابط النافبار على اليسار -->
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav me-auto my-2 my-lg-0">
                <li class="nav-item">

                <li class="nav-item dropdown">
                    <a class="nav-link user-icon" href="#" id="userMenu">
                        <i class="fa-solid fa-user"></i>
                    </a>
                    <div class="dropdown-menu" id="userDropdown">
                        <a class="dropdown-item" href="usersettings/user_settings.php" target="_blank">
                            <i class="fa-solid fa-user-gear"></i> إعدادت الحساب
                        </a>
                        <a class="dropdown-item" href="../index.html">
                            <i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج
                        </a>
                    </div>

                </li>

                </li>
                <li class="nav-item"><a class="nav-link" href="#contact">تواصل معنا</a></li>
                <li class="nav-item"><a class="nav-link" href="#service">خدمات</a></li>
                <li class="nav-item"><a class="nav-link" href="#announcements">اعلانات</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">عن البلدية</a></li>
            </ul>
        </div>

        <!-- الوعاء على اليمين: اجبرنا داخله اتجاه LTR لكي يظهر النص أولاً ثم الصورة على يمينه -->
        <div class="brand-wrap d-flex align-items-center" style="direction: ltr;">
            <a class="navbar-brand mb-0" href="#pageTop">بوابة مدينتي</a>
            <img src="../assets/img/bg-mobile-fallback.jpg" alt="Logo" style="width:44px; height:44px; display:inline-block; margin-left:10px;">
        </div>

        <!-- زر التوغل للجوال -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>



<!-- Masthead-->
<div class="masthead" id="pageTop">
    <div class="masthead-content text-white">
        <div class="container-fluid px-4 px-lg-0">
            <h2 class=" lh-1 mb-2">مرحبًا بك في مدينتك الرقمية</h2>

            <div class="user-welcome-card">
                <span class="welcome-text">اهلاً بك  </span>
                <span class="user-name"><?= htmlspecialchars($full_name) ?></span>
            </div>


            <p class="mb-5">كل ما تحتاجه... في مكان واحد!</p>
        </div>
    </div>
</div>

<section class="about-municipality" id="about">
    <div class="about-container">
        <div class="about-wrapper">

            <!-- ✅ نسخة الديسكتوب -->
            <div class="about-text desktop-full">
                <h2>نعمل من أجلكم… من أجل مدينتنا</h2>
                <ul class="about-list">
                    <li>خدمة المواطن هي أولويتنا في كل خطوة نخطوها.</li>
                    <li>نطوّر البنية التحتية باستمرار لنرتقي بجودة الحياة اليومية.</li>
                    <li>نقدّم خدمات رقمية تسهّل التواصل مع البلدية بسرعة وشفافية.</li>
                    <li>نصنع مشروعًا حضاريًا قائمًا على المشاركة والمسؤولية المجتمعية.</li>
                    <li>نهتم بجمال مدينتنا وبيئتها لتكون مكانًا نفخر به اليوم وغدًا.</li>
                </ul>
            </div>

            <div class="about-image">
                <img src="../assets/img/aboutIMG.jpg" alt="Municipality" />
            </div>

        </div>
    </div>
</section>

<section id="announcements" class="announcements-section">
    <div class="container">
        <h2 class="section-title">ابقَ على اطلاع بآخر أخبار البلدية</h2>
        <p class="section-subtitle">تابع أهم الأخبار، التنبيهات، والفعاليات في مدينتنا.</p>

        <!-- الأزرار -->
        <div class="announcement-tabs">
            <button class="tab-button active" data-tab="events">الفعاليات</button>
            <button class="tab-button" data-tab="news">الأخبار</button>
            <button class="tab-button" data-tab="alerts">التنبيهات</button>
        </div>

        <!-- المحتوى -->
        <div class="tab-content active" id="events">
            <div class="card">
                <img src="../assets/img/expo.jpg" alt="Event">
                <h3>مهرجان الصيف السنوي</h3>
                <p>انضم إلينا للاستمتاع بالموسيقى والطعام والأنشطة في ساحة المدينة</p>
            </div>
            <div class="card">
                <img src="../assets/img/clean.jpg" alt="Event">
                <h3>فعالية تنظيف الشوارع</h3>
                <p>شارك معنا في حملة تنظيف عامة للحفاظ على نظافة مدينتنا</p>
            </div>
            <div class="card">
                <img src="../assets/img/bazar.jpeg" alt="Event">
                <h3>بازار المنتجات المحلية</h3>
                <p>اكتشف أجمل المنتجات الحرفية من أبناء المدينة</p>
            </div>
        </div>

        <div class="tab-content" id="news">
            <div class="card">
                <img src="../assets/img/Street.jpg" alt="News">
                <h3>افتتاح طريق جديد</h3>
                <p>تم افتتاح الطريق الرابط بين وسط المدينة والحي الغربي لتسهيل التنقل</p>
            </div>
            <div class="card">
                <img src="../assets/img/dr.jpg" alt="News">
                <h3>تواجد دكتور في مستشفى البلدة</h3>
                <p>سيكون دكتور مختص متواجد لتقديم الاستشارات الطبية في المستشفى</p>
            </div>
            <div class="card">
                <img src="../assets/img/zaitoon.jpg" alt="News">
                <h3>زراعة أشجار جديدة</h3>
                <p>تمت زراعة 500 شجرة زيتون جديدة</p>
            </div>
        </div>

        <div class="tab-content" id="alerts">
            <div class="card">
                <img src="../assets/img/water.jpg" alt="Alert">
                <h3>صيانة شبكة المياه</h3>
                <p>سيتم قطع المياه في بعض المناطق يوم الجمعة لإجراء الصيانة</p>
            </div>
            <div class="card">
                <img src="../assets/img/close.jpg" alt="Alert">
                <h3>إغلاق مؤقت للطريق</h3>
                <p>سيتم إغلاق شارع البلدية الرئيسي مؤقتًا بسبب أعمال الحفر</p>
            </div>
            <div class="card">
                <img src="../assets/img/danger.jpg" alt="Alert">
                <h3>تحذير من العواصف</h3>
                <p>يرجى توخي الحذر خلال نهاية الأسبوع بسبب العواصف المتوقعة</p>
            </div>
        </div>
    </div>
</section>



<section id="service" class="services-section">
    <img src="../assets/img/road2.jpg" alt="خلفية الخدمات" class="service-bg">
    <div class="container">
        <h2 class="section-title">لوحة الخدمات</h2>
        <p class="section-subtitle">انجز معاملاتك بسهولة من مكانك</p>

        <div class="timeline">
            <!-- نهاية الخط: اختر ما يناسبك -->
            <div class="timeline-top">
                <div class="timeline-circle top-circle">
                    اختر ما يناسبك
                </div>
            </div>

            <!-- Service 1 -->
            <div class="timeline-item left">
                <div class="timeline-content">
                    <h3>دفع فواتير الكهرباء</h3>
                    <p>دفع فاتورة الكهرباء إلكترونياً بكل سهولة وأمان دون الحاجة للذهاب للمكاتب</p>
                    <a href="services/electric_service.php" class="service-btn">اشحن الآن</a>
                </div>
                <div class="timeline-circle">
                    <img src="../assets/img/elc.jpeg" alt="طلب خدمة">
                </div>
            </div>

            <!-- Service 2 -->
            <div class="timeline-item right">
                <div class="timeline-circle">
                    <img src="../assets/img/req.jpg" alt="تتبع المعاملة">
                </div>
                <div class="timeline-content">
                    <h3>طلب معاملة رسمية</h3>
                    <p>قدّم طلبك للحصول على أي وثيقة رسمية بخطوات بسيطة</p>
                    <a href="services/request_service.php" class="service-btn">اطلب الآن</a>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="timeline-item left">
                <div class="timeline-content">
                    <h3>دفع فواتير المياه</h3>
                    <p>سدد فاتورة المياه أونلاين خلال دقائق واحصل على إيصال فوري بالدفع</p>
                    <a href="services/water_service.php" class="service-btn">اشحن الآن</a>
                </div>
                <div class="timeline-circle">
                    <img src="../assets/img/wat.jpeg" alt="دفع الفواتير">
                </div>
            </div>

            <!-- Service 4 -->
            <div class="timeline-item right">
                <div class="timeline-circle">
                    <img src="../assets/img/note.jpeg" alt="الإشعارات">
                </div>
                <div class="timeline-content">
                    <h3>تقديم شكوى أو ملاحظة</h3>
                    <p>شاركنا ملاحظاتك أو قدّم شكوى لتحسين الخدمات، وسنتابع طلبك بأسرع وقت</p>
                    <a href="services/complaint_service.php" class="service-btn">قدم الآن</a>
                </div>
            </div>

            <!-- Service 5 -->
            <div class="timeline-item left">
                <div class="timeline-content">
                    <h3>حجز مواعيد</h3>
                    <p>احجز موعداً مسبقاً لزيارة البلدية واحصل على خدمة سريعة دون انتظار</p>
                    <a href="services/date_service.php" class="service-btn">احجز الآن</a>
                </div>
                <div class="timeline-circle">
                    <img src="../assets/img/date.png" alt="طلب خدمة">
                </div>
            </div>

            <!-- نهاية الخط: اختر ما يناسبك -->
            <div class="timeline-end">
                <div class="timeline-circle end-circle">
                    اختر ما يناسبك
                </div>
            </div>

        </div>
    </div>
</section>



<section class="reviews-section" id="reviews">
    <div class="reviews-left">
        <h2>أضف تقييمك ....</h2>
        <p class="sub">شاركنا رأيك حول الموقع</p>
    </div>

    <div class="reviews-container" >

        <button class="nav-btn" id="prevBtn">‹</button>

        <div class="review-main">
            <div class="review-cards-wrapper" id="feedbackContainer" >
                <!-- الكاردات -->
            </div>

            <button class="add-review-btn"  id="addReviewBtn" >أضف تقييمك</button>
        </div>


        <button class="nav-btn" id="nextBtn">›</button>


    </div>
</section>

<div id="reviewModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>أضف تقييمك</h3>
        <div class="stars-input">
            <span data-value="1">★</span>
            <span data-value="2">★</span>
            <span data-value="3">★</span>
            <span data-value="4">★</span>
            <span data-value="5">★</span>
        </div>
        <textarea id="reviewText" placeholder="اكتب تعليقك هنا"></textarea>
        <button id="sendReview">إرسال</button>
    </div>
</div>



<section id="contact" class="contact-map-section">
    <div class="contact-map-container">

        <!-- الخريطة -->
        <div class="map-box">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d54191.51729204024!2d35.247081871734906!3d31.90741706757433!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1502d54cda2d58d1%3A0xbf6d4d17cc8b2c76!2z2LHYp9mFINin2YTZhNmH!5e0!3m2!1sar!2s!4v1762553016184!5m2!1sar!2s"
                width="100%"
                height="100%"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>

        <!-- فورم التواصل -->
        <div class="contact-box">
            <h3>تواصل معنا</h3>
            <form id="contactForm">
                <input type="text" name="name" placeholder="اسمك" required>
                <input type="email" name="email" placeholder="البريد الإلكتروني" required>
                <input type="text" name="subject" placeholder="الموضوع" required>
                <textarea name="message" placeholder="رسالتك" required></textarea>
                <button type="submit">إرسال الرسالة</button>
            </form>

            <div id="contactMessage" style="text-align:center; margin-top:10px;"></div>

        </div>

    </div>

</section>




<!-- زر الروبوت العائم -->
<div id="chatbot-icon">
    <img src="../assets/img/chatbot.png" alt="chatbot">
</div>

<div class="start-content" id="chatbot-start">
    <img src="../assets/img/chatbot.png" alt="robot" class="robot-icon-large">
    <h2>مرحبًا بك أنا بيمو</h2>
    <p>سأجيب على استفساراتك والأسئلة الشائعة حول خدمات البلدية</p>
    <button id="start-chat">ابدأ الآن 🚀</button>
</div>




<!-- نافذة الدردشة -->
<div id="chatbot-modal">
    <div class="chat-header">
        <h3>BEMO</h3>
        <span id="close-chat">&times;</span>
    </div>

    <div class="chat-body" id="chat-body">
        <div class="bot-msg">🤖 أهلاً! أنا بيمو، كيف يمكنني خدمتك اليوم؟</div>
        <div class="question-list">
            <button class="question-btn">🕒 ما هي أوقات دوام البلدية؟</button>
            <button class="question-btn">💳 كيف يمكنني دفع الفواتير؟</button>
            <button class="question-btn">📍 أين تقع مكاتب البلدية؟</button>
            <button class="question-btn">📬 كيف أقدّم شكوى أو اقتراح؟</button>
            <button class="question-btn">💻 ما هي الخدمات الإلكترونية المتاحة؟</button>
        </div>
    </div>
</div>
<!-- for email-->

<script>
    const contactForm = document.getElementById('contactForm');
    const contactMessage = document.getElementById('contactMessage');

    contactForm.addEventListener('submit', function(e){
        e.preventDefault(); // منع إعادة التحميل

        const formData = new FormData(contactForm);

        fetch('adminphp/contactus.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                contactMessage.style.color = data.success ? 'green' : 'red';
                contactMessage.textContent = data.message;
                if(data.success) contactForm.reset();
            })
            .catch(error => {
                contactMessage.style.color = 'red';
                contactMessage.textContent = "حدث خطأ أثناء الإرسال: " + error;
            });
    });
</script>

<!-- JavaScript للشات بوت -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatbotIcon = document.getElementById("chatbot-icon");
        const startScreen = document.getElementById("chatbot-start");
        const startBtn = document.getElementById("start-chat");
        const chatbotModal = document.getElementById("chatbot-modal");
        const closeChat = document.getElementById("close-chat");
        const chatBody = document.getElementById("chat-body");

        const answers = {
            "🕒 ما هي أوقات دوام البلدية؟": "الدوام من الأحد إلى الخميس من الساعة 8 صباحًا حتى 2 ظهرًا.",
            "💳 كيف يمكنني دفع الفواتير؟": "يمكنك الدفع إلكترونيًا من خلال بطاقتك البنكية أو بطاقة ريفلكت وللمزيد توجه الى قسم الخدمات",
            "📍 أين تقع مكاتب البلدية؟": "تقع في وسط المدينة، شارع البلدية الرئيسي بجانب المركز الثقافي.",
            "📬 كيف أقدّم شكوى أو اقتراح؟": "من خلال قسم 'تواصل معنا' أو من خلال خدمة 'تقديم شكوى او ملاحظة' في قسم الخدمات ",
            "💻 ما هي الخدمات الإلكترونية المتاحة؟": "دفع الفواتير، تقديم الطلبات، حجز المواعيد، والمزيد."
        };

        // تأكد من وجود العناصر
        if (!chatbotIcon) {
            console.error("chatbot-icon not found!");
            return;
        }

        chatbotIcon.addEventListener("click", function(e) {
            e.stopPropagation();
            console.log("Robot clicked!"); // للتأكد إنه الكبسة شغالة
            startScreen.style.display = "flex";
        });

        startBtn.addEventListener("click", function() {
            startScreen.style.display = "none";
            chatbotModal.style.display = "flex";
        });

        closeChat.addEventListener("click", function() {
            chatbotModal.style.display = "none";
        });

        document.querySelectorAll(".question-btn").forEach(function(btn) {
            btn.addEventListener("click", function() {
                const question = btn.textContent;
                appendMessage(question, "user-msg");
                setTimeout(function() {
                    appendMessage(answers[question], "bot-msg");
                }, 600);
            });
        });

        function appendMessage(text, className) {
            const div = document.createElement("div");
            div.className = className;
            div.textContent = text;
            chatBody.insertBefore(div, document.querySelector(".question-list"));
            chatBody.scrollTop = chatBody.scrollHeight;
        }
    });
</script>






<script>
    const navbar = document.querySelector('#mainNav');

    window.addEventListener('scroll', () => {
        if(window.scrollY > 50){ // الصفحة تم تمريرها أكثر من 50px
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>

<script>
    // جلب كل الأزرار والمحتوى
    const buttons = document.querySelectorAll('.tab-button');
    const contents = document.querySelectorAll('.tab-content');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            // إزالة class active من كل الأزرار والمحتوى
            buttons.forEach(btn => btn.classList.remove('active'));
            contents.forEach(content => content.classList.remove('active'));

            // إضافة active للزر والمحتوى المختار
            button.classList.add('active');
            const tabId = button.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });
</script>


<!-- user profile -->
<script>
    const userIcon = document.getElementById('userMenu');
    const userDropdown = document.getElementById('userDropdown');

    userIcon.addEventListener('click', (e) => {
        e.preventDefault();
        userDropdown.style.display = userDropdown.style.display === 'block' ? 'none' : 'block';
    });

    // إغلاق القائمة عند الضغط خارجها
    document.addEventListener('click', (e) => {
        if (!userIcon.contains(e.target) && !userDropdown.contains(e.target)) {
            userDropdown.style.display = 'none';
        }
    });
</script>




<script>
    let currentIndex = 0;
    let cards = [];

    // تحميل الفيدباك
    fetch("get_feedback.php")
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById("feedbackContainer");
            container.innerHTML = "";

            data.forEach((fb, index) => {
                const card = document.createElement("div");
                card.className = "review-card" + (index === 0 ? " active" : "");

                card.innerHTML = `
    <div class="author">
        <div>
            <strong>${fb.full_name ?? 'مستخدم'}</strong><br>
            <span>${new Date(fb.created_at).toLocaleDateString()}</span>
        </div>
    </div>

    <div class="review-stars">
        ${'★'.repeat(fb.rating)}${'☆'.repeat(5 - fb.rating)}
    </div>

    <p class="review-text">${fb.text}</p>
`;


                container.appendChild(card);
            });

            cards = document.querySelectorAll(".review-card");
        });

    // التنقل
    document.getElementById("prevBtn").onclick = () => {
        cards[currentIndex].classList.remove("active");
        currentIndex = (currentIndex - 1 + cards.length) % cards.length;
        cards[currentIndex].classList.add("active");
    };

    document.getElementById("nextBtn").onclick = () => {
        cards[currentIndex].classList.remove("active");
        currentIndex = (currentIndex + 1) % cards.length;
        cards[currentIndex].classList.add("active");
    };

    // إرسال فيدباك
    document.getElementById("sendReview").addEventListener("click", () => {
        const text = document.getElementById("reviewText").value.trim();

        if (!text || rating === 0) {
            alert("اكتبي تعليق واختاري عدد النجوم");
            return;
        }

        const fd = new FormData();
        fd.append("text", text);
        fd.append("rating", rating);

        fetch("add_feedback.php", {
            method: "POST",
            body: fd
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            });
    });
</script>


<script>
    // ===== Modal controls =====
    const modal = document.getElementById("reviewModal");
    const addBtn = document.getElementById("addReviewBtn");
    const closeBtn = document.querySelector("#reviewModal .close");

    addBtn.addEventListener("click", () => {
        modal.style.display = "block";
    });

    closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
    });

    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });

    // ===== Stars rating =====
    const stars = document.querySelectorAll(".stars-input span");
    let rating = 0;

    stars.forEach(star => {
        star.addEventListener("click", () => {
            rating = parseInt(star.dataset.value);
            updateStars(rating);
        });

        star.addEventListener("mouseover", () => {
            updateStars(parseInt(star.dataset.value));
        });

        star.addEventListener("mouseout", () => {
            updateStars(rating);
        });
    });

    function updateStars(value) {
        stars.forEach(star => {
            star.classList.toggle(
                "selected",
                parseInt(star.dataset.value) <= value
            );
        });
    }
</script>




</body>
</html>