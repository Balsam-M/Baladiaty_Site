<?php include '../db.php'; ?>

<style>
    /* --------------------- أسلوب جدول الإعلانات --------------------- */
    .announcements-container {
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .announcements-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .announcements-title {
        font-size: 1.5rem;
    }

    .add-announcement-btn {
        padding: 6px 12px;
        font-size: 1rem;
        cursor: pointer;
        background-color: #4da6ff;
        color: #fff;
        border: none;
        border-radius: 5px;
    }

    .add-announcement-btn:hover {
        background-color: #3498db;
    }

    .announcements-table-wrapper {
        margin-top: 10px;
    }

    #announcementsTable table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border: 2px solid #1f4e79;
    }

    #announcementsTable th, #announcementsTable td {
        border: 1px solid #1f4e79;
        padding: 8px;
        text-align: center;
    }

    #announcementsTable th {
        background-color: #b9a292;
        font-weight: bold;
    }

    #announcementsTable tr:hover {
        background-color: #e6f0ff;
        transition: 0.2s;
    }

    .editAnnouncementBtn {
        background-color: #80c1ff;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .editAnnouncementBtn:hover {
        background-color: #bf7a44;
    }

    .deleteAnnouncementBtn {
        background-color: #004080;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .deleteAnnouncementBtn:hover {
        background-color: #D4BCA1;
    }

    /* --------------------- الفورم مودال --------------------- */
    .announcement-form {
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

    .announcement-form:hover {
        transform: translate(-50%, -50%) scale(1.02);
        box-shadow: 0 12px 35px rgba(0,0,0,0.3);
    }

    .announcement-form .form-input textarea {
        width: 100%;
        padding: 10px 15px;
        margin-bottom: 12px;
        border-radius: 15px;
        border: 1px solid #ccc;
        font-size: 1rem;
        resize: vertical;
        min-height: 80px;
    }

    .announcement-form .save-btn {
        background-color: #ac6532;
        color: white;
        border-radius: 25px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }
    .announcement-form .save-btn:hover {
        background-color: #31b0d5;
    }

    .announcement-form .cancel-btn {
        background-color: #bf7a44;
        color: white;
        border-radius: 25px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }
    .announcement-form .cancel-btn:hover {
        background-color: #0056b3;
    }


    .announcements-container {
        padding: 20px;
        font-family: Arial, sans-serif;
        margin-right: 270px; /* عرض sidebar + 10px */
    }

    .announcements-table-wrapper {
        margin-top: 10px;
        overflow-x: auto; /* يظهر شريط تمرير أفقي إذا كان الجدول كبير */
    }

    #announcementsTable table {
        width: 100%;
        min-width: 900px; /* أو حسب عدد الأعمدة */
        border-collapse: collapse;
    }
</style>

<div class="announcements-container">

    <div class="announcements-header">
        <h3 class="announcements-title" id="modalTitle">صفحة الإعلانات</h3>
        <button class="add-announcement-btn" id="addAnnouncementBtn">إضافة إعلان</button>
    </div>

    <div class="announcements-table-wrapper">
        <div id="announcementsTable">
            <!-- سيتم تعبئته ديناميكياً بواسطة get_announcements.php -->
        </div>
    </div>

    <!-- الفورم لإضافة/تعديل إعلان -->
    <div class="announcement-form" id="announcementForm">
        <h3 id="modalTitleForm"></h3>

        <input type="hidden" id="announcementId">
        <div class="form-input">
            <textarea id="announcementContent" placeholder="نص الإعلان"></textarea>
        </div>

        <div class="form-buttons">
            <button class="save-btn" id="saveAnnouncementBtn">حفظ</button>
            <button class="cancel-btn" id="cancelAnnouncementBtn">إلغاء</button>
        </div>
    </div>

</div>


<script src="js/announcementscript.js"></script>