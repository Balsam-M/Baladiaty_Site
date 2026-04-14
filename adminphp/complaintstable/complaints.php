<?php include '../db.php'; ?>

<style>
    /* --------------------- أسلوب جدول الشكاوى --------------------- */
    .complaints-container {
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .complaints-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .complaints-title {
        font-size: 1.5rem;
    }

    .add-complaint-btn {
        padding: 6px 12px;
        font-size: 1rem;
        cursor: pointer;
        background-color: #4da6ff;
        color: #fff;
        border: none;
        border-radius: 5px;
    }

    .add-complaint-btn:hover {
        background-color: #3498db;
    }

    .complaints-table-wrapper {
        margin-top: 10px;
    }

    #complaintsTable table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border: 2px solid #1f4e79;
    }

    #complaintsTable th, #complaintsTable td {
        border: 1px solid #1f4e79;
        padding: 8px;
        text-align: center;
    }

    #complaintsTable th {
        background-color: #b9a292;
        font-weight: bold;
    }

    #complaintsTable tr:hover {
        background-color: #e6f0ff;
        transition: 0.2s;
    }

    /* --------------------- أزرار الجدول --------------------- */
    .editComplaintBtn {
        background-color: #80c1ff;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .editComplaintBtn:hover {
        background-color: #bf7a44;
    }

    .deleteComplaintBtn {
        background-color: #004080;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .deleteComplaintBtn:hover {
        background-color: #D4BCA1;
    }

    /* --------------------- الفورم مودال --------------------- */
    .complaint-form {
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

    .complaint-form:hover {
        transform: translate(-50%, -50%) scale(1.02);
        box-shadow: 0 12px 35px rgba(0,0,0,0.3);
    }

    .complaint-form .form-input input,
    .complaint-form .form-input select,
    .complaint-form .form-input textarea {
        width: 100%;
        padding: 10px 15px;
        margin-bottom: 12px;
        border-radius: 25px;
        border: 1px solid #ccc;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .complaint-form .form-input input:focus,
    .complaint-form .form-input select:focus,
    .complaint-form .form-input textarea:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 6px rgba(0,123,255,0.4);
    }

    #modalTitle {
        color: #1f4e79;
        font-weight: bold;
    }

    .complaint-form .save-btn {
        background-color: #ac6532;
        color: white;
        border-radius: 25px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }

    .complaint-form .save-btn:hover {
        background-color: #31b0d5;
    }

    .complaint-form .cancel-btn {
        background-color: #bf7a44;
        color: white;
        border-radius: 25px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }

    .complaint-form .cancel-btn:hover {
        background-color: #0056b3;
    }


    .complaints-container {
        padding: 20px;
        font-family: Arial, sans-serif;
        margin-right: 270px; /* عرض sidebar + 10px */
    }

    .complaints-table-wrapper {
        margin-top: 10px;
        overflow-x: auto; /* يظهر شريط تمرير أفقي إذا كان الجدول كبير */
    }

    #complaintsTable table {
        width: 100%;
        min-width: 900px; /* أو حسب عدد الأعمدة */
        border-collapse: collapse;
    }

</style>

<div class="complaints-container">

    <div class="complaints-header">
        <h3 class="complaints-title" id="modalTitle">صفحة الشكاوى</h3>
        <button class="add-complaint-btn" id="addComplaintBtn">إضافة شكوى</button>
    </div>

    <div class="complaints-table-wrapper">
        <div id="complaintsTable">
            <!-- سيتم تعبئته ديناميكياً -->
        </div>
    </div>

    <div class="complaint-form" id="complaintForm">
        <h3 id="modalTitleForm" style="margin-bottom: 15px;"></h3>

        <!-- الحقل المخفي للـ ID -->
        <input type="hidden" id="complaintId">

        <div class="form-input"><input type="text" id="complaintUserId" placeholder="رقم المستخدم"></div>
        <div class="form-input"><input type="text" id="complaintTitle" placeholder="عنوان الشكوى"></div>
        <div class="form-input"><textarea id="complaintDescription" placeholder="التفاصيل" rows="4"></textarea></div>
        <div class="form-input">
            <select id="complaintStatus">
                <option value="pending">قيد الانتظار</option>
                <option value="approved">موافق عليه</option>
                <option value="rejected">مرفوض</option>
            </select>
        </div>

        <div class="form-buttons">
            <button class="save-btn" id="saveComplaintBtn">حفظ</button>
            <button class="cancel-btn" id="cancelComplaintBtn">إلغاء</button>
        </div>
    </div>

</div>

<script src="js/complaintscript.js"></script>
