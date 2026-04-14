<!-- Admin Settings Form -->
<div class="admin-settings-form">
    <h3>إعدادات الحساب</h3>

    <div class="form-row">
        <label>الاسم الكامل
            <input type="text" id="adminFullName" placeholder="ادخل الاسم الكامل" />
        </label>
        <label>البريد الإلكتروني
            <input type="email" id="adminEmail" placeholder="example@mail.com" />
        </label>
    </div>

    <div class="form-row">
        <label>رقم الهاتف
            <input type="text" id="adminPhone" placeholder="0599-000-000" />
        </label>
        <label>المدينة
            <input type="text" id="adminCity" placeholder="المدينة" />
        </label>
    </div>

    <div class="form-row">
        <label>الشارع
            <input type="text" id="adminStreet" placeholder="الشارع" />
        </label>
        <label>رقم الفيزا
            <input type="text" id="adminVisaNumber" placeholder="0000-0000-0000-0000" />
        </label>
    </div>

    <!-- حقل تغيير كلمة المرور -->
    <div class="form-row">
        <label>كلمة المرور الجديدة
            <input type="password" id="adminNewPassword" placeholder="********" />
        </label>
        <label>تأكيد كلمة المرور
            <input type="password" id="adminConfirmPassword" placeholder="********" />
        </label>
    </div>
    <div class="form-buttons">
        <button id="cancelAdminSettings" class="cancel">❌ إلغاء</button>
        <button id="saveAdminSettings" class="save">💾 حفظ التعديلات</button>
    </div>
</div>

<style>
    .admin-settings-form {
        background: rgba(255,255,255,0.85) url('assets/img/back1.jpeg') no-repeat center center;
        background-size: cover;
        padding: 30px; /* قللنا من 50px إلى 30px */
        border-radius: 30px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
        max-width: 1200px; /* قللنا من 1200px */
        min-height: 200px; /* قللنا من 500px */
        margin: 10px 350px 40px 40px; /* top right bottom left */
        font-family: "Cairo", sans-serif;
        transition: all 0.3s ease-in-out;
    }

    .admin-settings-form:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.25);
    }


    .admin-settings-form h3 {
        text-align: right;
        margin-bottom: 35px;
        color: #0a5d7a;
        font-size: 24px;
    }

    .admin-settings-form .form-row {
        display: flex;
        gap: 5px; /* تقليل الفراغ بين الحقول */
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .admin-settings-form label {
        flex: 0 0 48%;
        display: flex;
        flex-direction: column;
        font-weight: bold;
        font-size: 16px;
        text-align: right;
    }

    /* الحقول تبقى بنفس الحجم */
    .admin-settings-form input {
        padding: 18px 15px;
        margin-top: 8px;
        border-radius: 12px;
        border: 1px solid #ccc;
        background: #fafafa;
        font-size: 18px;
        width: 60%;
        box-sizing: border-box;
        transition: 0.3s;
    }

    .admin-settings-form input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 10px rgba(255, 450, 150, 0.3);
        outline: none;
    }

    .admin-settings-form .form-buttons {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 35px;
        transform: translateX(150px);
    }

    .admin-settings-form button {
        padding: 16px 32px;
        border-radius: 12px;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .admin-settings-form button.save {
        background-color: #567c8d;
        color: white;
        border: none;
    }

    .admin-settings-form button.save:hover {
        background-color:  #b9a292;
        transform: translateY(-2px);
    }

    .admin-settings-form button.cancel {
        background-color: #f2f2f2;
        color: #555;
        border: 1px solid #ccc;
    }

    .admin-settings-form button.cancel:hover {
        background-color: #ddd;
        transform: translateY(-2px);
    }
</style>


<script>
    document.getElementById('saveAdminSettings').onclick = () => {
        let newPass = document.getElementById('adminNewPassword').value;
        let confirm = document.getElementById('adminConfirmPassword').value;

        let fullName = document.getElementById('adminFullName').value;
        let email    = document.getElementById('adminEmail').value;
        let phone    = document.getElementById('adminPhone').value;
        let city     = document.getElementById('adminCity').value;
        let street   = document.getElementById('adminStreet').value;
        let visa     = document.getElementById('adminVisaNumber').value;

        if(newPass && newPass !== confirm){
            alert("كلمة المرور الجديدة لا تتطابق مع التأكيد!");
            return;
        }

        let formData = new FormData();
        formData.append('new_password', newPass);
        formData.append('confirm_password', confirm);
        formData.append('full_name', fullName);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('city', city);
        formData.append('street', street);
        formData.append('visa_number', visa);

        fetch('adminphp/adminsettings/update_admin.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.text())
            .then(res => alert(res));
    };
</script>