<?php include 'db.php'; ?>

<style>
    /* Box sizing لكل العناصر */
    * {
        box-sizing: border-box;
    }

    /* --------------------- أسلوب جدول المستخدمين --------------------- */
    .users-container {
        padding: 20px;
        font-family: Arial, sans-serif;
        margin-right: 20px; /* مسافة من sidebar */
    }

    /* Header */
    .users-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .users-title {
        font-size: 1.5rem;
    }

    .add-user-btn {
        padding: 6px 12px;
        font-size: 1rem;
        cursor: pointer;
        background-color: #4da6ff;
        color: #fff;
        border: none;
        border-radius: 5px;
    }

    .add-user-btn:hover {
        background-color: #3498db;
    }

    .users-table-wrapper {
        margin-top: 10px;
        overflow-x: auto; /* يمنع تجاوز الجدول */
    }

    #usersTable table {
        width: 100%;
        max-width: 100%; /* يمنع تجاوز الـ content */
        border-collapse: collapse;
        background: white;
        border: 2px solid #1f4e79;
    }

    #usersTable th, #usersTable td {
        border: 1px solid #1f4e79;
        padding: 8px;
        text-align: center;
    }

    #usersTable th {
        background-color: #b9a292;
        font-weight: bold;
    }

    #usersTable tr:hover {
        background-color: #e6f0ff;
        transition: 0.2s;
    }

    /* أزرار الجدول */
    .editUserBtn, .deleteUserBtn {
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .editUserBtn { background-color: #80c1ff; }
    .editUserBtn:hover { background-color: #bf7a44; }
    .deleteUserBtn { background-color: #004080; }
    .deleteUserBtn:hover { background-color: #D4BCA1; }

    /* --------------------- الفورم مودال --------------------- */
    .user-form {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 450px;
        padding: 25px;
        background-color:#567c8d;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        z-index: 1000;
        transition: all 0.4s ease;
    }

    .user-form:hover {
        transform: translate(-50%, -50%) scale(1.02);
        box-shadow: 0 12px 35px rgba(0,0,0,0.3);
    }

    .user-form .form-input input {
        width: 100%;
        padding: 10px 15px;
        margin-bottom: 12px;
        border-radius: 25px;
        border: 1px solid #ccc;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .user-form .form-input input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 6px rgba(0,123,255,0.4);
    }

    #modalTitle {
        color: #1f4e79;
        font-weight: bold;
    }

    .user-form .save-btn {
        background-color: #ac6532;
        color: white;
        border-radius: 25px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }
    .user-form .save-btn:hover { background-color: #31b0d5; }

    .user-form .cancel-btn {
        background-color: #bf7a44;
        color: white;
        border-radius: 25px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }
    .user-form .cancel-btn:hover { background-color: #0056b3; }


    .users-container {
        padding: 20px;
        font-family: Arial, sans-serif;
        margin-right: 270px; /* عرض sidebar + 10px */
    }

    .users-table-wrapper {
        margin-top: 10px;
        overflow-x: auto; /* يظهر شريط تمرير أفقي إذا كان الجدول كبير */
    }

    #usersTable table {
        width: 100%;
        min-width: 900px; /* أو حسب عدد الأعمدة */
        border-collapse: collapse;
    }
</style>

<div class="users-container">

    <div class="users-header">
        <h3 class="users-title" id="modalTitle">صفحة المستخدمين</h3>
        <button class="add-user-btn" id="addUserBtn">إضافة مستخدم</button>
    </div>

    <div class="users-table-wrapper">
        <div id="usersTable">
            <!-- سيتم تعبئته ديناميكياً -->
        </div>
    </div>

    <div class="user-form" id="userForm">
        <div class="form-input"><input type="text" id="userId" placeholder="رقم الهوية"></div>
        <div class="form-input"><input type="text" id="userName" placeholder="الاسم"></div>
        <div class="form-input"><input type="email" id="userEmail" placeholder="البريد الإلكتروني"></div>
        <div class="form-input"><input type="password" id="userPassword" placeholder="كلمة المرور"></div>
        <div class="form-input"><input type="text" id="userPhone" placeholder="الهاتف"></div>
        <div class="form-input"><input type="date" id="userDOB" placeholder="تاريخ الميلاد"></div>
        <div class="form-input"><input type="text" id="userCity" placeholder="المدينة"></div>
        <div class="form-input"><input type="text" id="userStreet" placeholder="الشارع"></div>
        <div class="form-input"><input type="text" id="userVisa" placeholder="رقم الفيزا"></div>

        <div class="form-buttons">
            <button class="save-btn" id="saveUserBtn">حفظ</button>
            <button class="cancel-btn" id="cancelUserBtn">إلغاء</button>
        </div>
    </div>

</div>

<script src="js/script.js"></script>
