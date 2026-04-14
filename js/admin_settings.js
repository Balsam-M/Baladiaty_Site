// ----------------------------
// Admin Settings Script
// ----------------------------

const adminSettingsBtn = document.querySelector('[data-page="admins"]');

if (adminSettingsBtn) {
    adminSettingsBtn.addEventListener('click', function () {
        loadPage(
            'admins',
            'adminphp/adminsettings/admin_settings.php',
            initAdminSettings
        );

        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        this.classList.add('active');
    });
}

function initAdminSettings() {

    // تحميل بيانات الادمن
    fetch('adminphp/adminsettings/get_admin.php')
        .then(res => res.json())
        .then(data => {
            document.getElementById('adminFullName').value = data.full_name;
            document.getElementById('adminEmail').value = data.email;
            document.getElementById('adminPhone').value = data.phone;
            document.getElementById('adminCity').value = data.city;
            document.getElementById('adminStreet').value = data.street;
            document.getElementById('adminVisaNumber').value = data.visa_number ?? '';
        });

    // حفظ التعديلات
    document.getElementById('saveAdminSettings').onclick = function () {

        const formData = new FormData();
        formData.append('full_name', document.getElementById('adminFullName').value);
        formData.append('email', document.getElementById('adminEmail').value);
        formData.append('phone', document.getElementById('adminPhone').value);
        formData.append('city', document.getElementById('adminCity').value);
        formData.append('street', document.getElementById('adminStreet').value);
        formData.append('visa_number', document.getElementById('adminVisaNumber').value);

        const newPass = document.getElementById('adminNewPassword').value;
        const confirm = document.getElementById('adminConfirmPassword').value;

        // تحقق من مطابقة كلمة المرور الجديدة والتأكيد
        if(newPass && newPass !== confirm){
            alert("كلمة المرور الجديدة لا تتطابق مع التأكيد!");
            return;
        }

        formData.append('new_password', newPass);
        formData.append('confirm_password', confirm);

        fetch('adminphp/adminsettings/update_admin.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(res => {
                if(res.status === "success"){
                    alert("تم حفظ التعديلات بنجاح!");
                    // إعادة تعبئة الفورم مباشرة بالقيم الجديدة
                    document.getElementById('adminFullName').value = res.full_name;
                    document.getElementById('adminEmail').value = res.email;
                    document.getElementById('adminPhone').value = res.phone;
                    document.getElementById('adminCity').value = res.city;
                    document.getElementById('adminStreet').value = res.street;
                    document.getElementById('adminVisaNumber').value = res.visa_number;
                    // تفريغ حقلي كلمة المرور
                    document.getElementById('adminNewPassword').value = '';
                    document.getElementById('adminConfirmPassword').value = '';
                } else {
                    alert("حدث خطأ: " + res.message);
                }
            })
            .catch(err => console.error(err));
    };
}
