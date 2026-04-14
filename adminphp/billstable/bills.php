<?php
include '../db.php';
?>

<style>
    /* --------------------- أسلوب جدول الفواتير --------------------- */
    .bills-container {
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .bills-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .bills-title {
        font-size: 1.5rem;
    }

    .add-bill-btn {
        padding: 6px 12px;
        font-size: 1rem;
        cursor: pointer;
        background-color: #4da6ff;
        color: #fff;
        border: none;
        border-radius: 5px;
    }

    .add-bill-btn:hover {
        background-color: #3498db;
    }

    .bills-table-wrapper {
        margin-top: 10px;
    }

    #billsTable table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border: 2px solid #1f4e79;
    }

    #billsTable th, #billsTable td {
        border: 1px solid #1f4e79;
        padding: 8px;
        text-align: center;
    }

    #billsTable th {
        background-color: #b9a292;
        font-weight: bold;
    }

    #billsTable tr:hover {
        background-color: #e6f0ff;
        transition: 0.2s;
    }

    /* أزرار الجدول */
    .editBillBtn {
        background-color: #80c1ff;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .editBillBtn:hover {
        background-color: #bf7a44;
    }
    .editBillBtn:active {
        background-color: #bf7a44;
    }

    .deleteBillBtn {
        background-color: #004080;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .deleteBillBtn:hover {
        background-color: #D4BCA1;
    }
    .deleteBillBtn:active {
        background-color: #D4BCA1;
    }

    /* --------------------- الفورم مودال --------------------- */
    .bill-form {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 450px;
        padding: 25px;
        background-color: #567c8d;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        z-index: 1000;
        transition: all 0.4s ease;
    }

    .bill-form:hover {
        transform: translate(-50%, -50%) scale(1.02);
        box-shadow: 0 12px 35px rgba(0,0,0,0.3);
    }

    .bill-form .form-input input {
        width: 100%;
        padding: 10px 15px;
        margin-bottom: 12px;
        border-radius: 25px;
        border: 1px solid #ccc;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .bill-form .form-input input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 6px rgba(0,123,255,0.4);
    }

    /* عنوان المودال */
    #billModalTitle {
        color: #1f4e79;
        font-weight: bold;
        margin-bottom: 15px;
    }

    /* أزرار الحفظ والإلغاء */
    .bill-form .save-btn {
        background-color: #ac6532;
        color: white;
        border-radius: 25px;
        padding: 8px 20px;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .bill-form .save-btn:hover {
        background-color: #31b0d5;
    }

    .bill-form .cancel-btn {
        background-color: #bf7a44;
        color: white;
        border-radius: 25px;
        padding: 8px 20px;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .bill-form .cancel-btn:hover {
        background-color: #0056b3;
    }

    .bills-container {
        padding: 20px;
        font-family: Arial, sans-serif;
        margin-right: 270px; /* عرض sidebar + 10px */
    }

    .bills-table-wrapper {
        margin-top: 10px;
        overflow-x: auto; /* يظهر شريط تمرير أفقي إذا كان الجدول كبير */
    }

    #billsTable table {
        width: 100%;
        min-width: 900px; /* أو حسب عدد الأعمدة */
        border-collapse: collapse;
    }
</style>

<div class="bills-container">
    <div class="bills-header">
        <h3 class="bills-title" id="billModalTitle">صفحة الفواتير</h3>
        <button class="add-bill-btn" id="addBillBtn">إضافة فاتورة</button>
    </div>

    <div class="bills-table-wrapper">
        <div id="billsTable">
            <!-- سيتم تحميل الجدول ديناميكياً -->
        </div>
    </div>

    <div class="bill-form" id="billForm">
        <h3 id="billModalTitle"></h3>
        <div class="form-input"><input type="text" id="billId" placeholder="رقم الفاتورة" readonly></div>
        <div class="form-input"><input type="text" id="billUserId" placeholder="رقم المستخدم"></div>
        <div class="form-input"><input type="text" id="billType" placeholder="نوع الفاتورة"></div>
        <div class="form-input"><input type="number" id="billAmount" placeholder="المبلغ الكلي" step="0.01"></div>
        <div class="form-input"><input type="date" id="billDate" placeholder="تاريخ الفاتورة"></div>

        <div class="form-buttons">
            <button class="save-btn" id="saveBillBtn">حفظ</button>
            <button class="cancel-btn" id="cancelBillBtn">إلغاء</button>
        </div>
    </div>
</div>

<script src="js/billsscript.js"></script>
