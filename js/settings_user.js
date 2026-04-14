document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('personalForm');

    // ✅ جلب بيانات المستخدم
    fetch('../adminphp/usersettings/get_user.php')
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            for (let key in data) {
                const input = document.getElementById(key);
                if (input) {
                    input.value = data[key] ?? '';
                }
            }
        })
        .catch(err => {
            console.error(err);
            alert('خطأ في تحميل البيانات');
        });

    // ✅ حفظ التعديلات
    form.addEventListener('submit', e => {
        e.preventDefault();

        fetch('../adminphp/usersettings/update_user.php', {
            method: 'POST',
            body: new FormData(form)
        })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    alert('تم حفظ التعديلات بنجاح ✅');
                } else {
                    alert(res.message || 'فشل التحديث ❌');
                }
            })
            .catch(() => alert('خطأ في الاتصال'));
    });

});
