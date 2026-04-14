<?php include '../db.php'; ?>

<style>
    /* --------------------- أسلوب جدول الطلبات --------------------- */
    .orders-container {
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .orders-title {
        font-size: 1.5rem;
    }

    .add-order-btn {
        padding: 6px 12px;
        font-size: 1rem;
        cursor: pointer;
        background-color: #4da6ff; /* أزرق فاتح */
        color: #fff;
        border: none;
        border-radius: 5px;
    }

    .add-order-btn:hover {
        background-color: #3498db;
    }

    .orders-table-wrapper {
        margin-top: 10px;
    }

    #ordersTable table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border: 2px solid #1f4e79;
    }

    #ordersTable th, #ordersTable td {
        border: 1px solid #1f4e79;
        padding: 8px;
        text-align: center;
    }

    #ordersTable th {
        background-color: #b9a292;
        font-weight: bold;
    }

    #ordersTable tr:hover {
        background-color: #e6f0ff;
        transition: 0.2s;
    }

    /* --------------------- أزرار الجدول --------------------- */
    .editOrderBtn {
        background-color: #80c1ff;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .editOrderBtn:hover {
        background-color: #bf7a44;
    }
    .deleteOrderBtn {
        background-color: #004080;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .deleteOrderBtn:hover {
        background-color: #D4BCA1;
    }

    /* --------------------- الفورم مودال --------------------- */
    .order-form {
        display: none; /* مخفي افتراضياً */
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 450px;
        padding: 25px;
        background-color:#567c8d ; /* خلفية بيج فاتحة */
        border-radius: 15px; /* بيضاوي */
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        z-index: 1000;
        transition: all 0.4s ease; /* transition على الفتح والإغلاق */
    }

    .order-form:hover {
        transform: translate(-50%, -50%) scale(1.02);
        box-shadow: 0 12px 35px rgba(0,0,0,0.3);
    }

    .order-form .form-input input,
    .order-form .form-input select {
        width: 100%;
        padding: 10px 15px;
        margin-bottom: 12px;
        border-radius: 25px;
        border: 1px solid #ccc;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .order-form .form-input input:focus,
    .order-form .form-input select:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 6px rgba(0,123,255,0.4);
    }

    #modalTitle {
        color: #1f4e79; /* أزرق غامق */
        font-weight: bold;
    }

    .order-form .save-btn {
        background-color: #ac6532;
        color: white;
        border-radius: 25px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }
    .order-form .save-btn:hover {
        background-color: #31b0d5;
    }

    .order-form .cancel-btn {
        background-color: #bf7a44;
        color: white;
        border-radius: 25px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }
    .order-form .cancel-btn:hover {
        background-color: #0056b3;
    }

    .orders-container {
        padding: 20px;
        font-family: Arial, sans-serif;
        margin-right: 270px; /* عرض sidebar + 10px */
    }

    .orders-table-wrapper {
        margin-top: 10px;
        overflow-x: auto; /* يظهر شريط تمرير أفقي إذا كان الجدول كبير */
    }

    #ordersTable table {
        width: 100%;
        min-width: 900px; /* أو حسب عدد الأعمدة */
        border-collapse: collapse;
    }
</style>

<div class="orders-container">

    <div class="orders-header">
        <h3 class="orders-title" id="modalTitle">صفحة الطلبات</h3>
        <button class="add-order-btn" id="addOrderBtn">إضافة طلب</button>
    </div>

    <div class="orders-table-wrapper">
        <div id="ordersTable">
            <!-- سيتم تعبئته ديناميكياً -->
        </div>
    </div>
    <div class="order-form" id="orderForm">
        <h3 id="modalTitleForm" style="margin-bottom: 15px;"></h3>

        <!-- الحقل المخفي للـ ID -->
        <input type="hidden" id="orderId">

        <div class="form-input"><input type="text" id="orderUserId" placeholder="رقم المستخدم"></div>
        <div class="form-input"><input type="text" id="orderDocumentType" placeholder="نوع الوثيقة"></div>
        <div class="form-input"><input type="text" id="orderDetails" placeholder="التفاصيل"></div>
        <div class="form-input">
            <select id="orderStatus">
                <option value="pending">قيد الانتظار</option>
                <option value="approved">موافق عليه</option>
                <option value="rejected">مرفوض</option>
            </select>
        </div>

        <div class="form-buttons">
            <button class="save-btn" id="saveOrderBtn">حفظ</button>
            <button class="cancel-btn" id="cancelOrderBtn">إلغاء</button>
        </div>
    </div>


<script src="js/orderscript.js"></script>
