// ----------------------------
// Switching pages without refresh
// ----------------------------
document.querySelectorAll(".nav-link").forEach(link => {
    link.addEventListener("click", function () {
        // إزالة الكلاس active من كل الروابط
        document.querySelectorAll(".nav-link").forEach(l => l.classList.remove("active"));
        this.classList.add("active");

        // عرض الصفحة المطلوبة
        const page = this.getAttribute("data-page");
        document.querySelectorAll(".page").forEach(p => p.classList.remove("active"));
        document.getElementById(page).classList.add("active");
    });
});

// ----------------------------
// تحميل صفحة داخل div
// ----------------------------
function loadPage(divId, url, initFunc) {
    const container = document.getElementById(divId);
    container.innerHTML = '<div class="text-center py-4">جارٍ التحميل...</div>';

    fetch(url)
        .then(response => response.text())
        .then(html => {
            container.innerHTML = html;
            if (initFunc) initFunc();
        })
        .catch(error => {
            container.innerHTML = '<div class="text-danger p-3">حدث خطأ أثناء التحميل.</div>';
            console.error(error);
        });
}

// ----------------------------
// صفحة المستخدمين
// ----------------------------
const usersBtn = document.querySelector('[data-page="users"]');
if (usersBtn) {
    usersBtn.addEventListener('click', function () {
        loadPage('users', 'adminphp/users.php', initUsers);
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        document.getElementById('users').classList.add('active');
    });
}

function initUsers() {
    let isEditMode = false; // false = إضافة، true = تعديل

    // ---------------- تحميل المستخدمين (يدعم البحث) ----------------
    function loadUsers(search = "") {
        fetch('adminphp/get_users.php?search=' + encodeURIComponent(search))
            .then(res => res.text())
            .then(html => {
                document.getElementById('usersTable').innerHTML = html;
                attachUserEvents();
            });
    }

    // ---------------- ربط الأحداث على أزرار الجدول ----------------
    function attachUserEvents() {
        // تعديل المستخدم
        document.querySelectorAll('.editUserBtn').forEach(btn => {
            btn.onclick = () => {
                const row = btn.parentElement.parentElement;
                document.getElementById('userId').value = row.children[0].innerText;
                document.getElementById('userName').value = row.children[1].innerText;
                document.getElementById('userEmail').value = row.children[2].innerText;
                document.getElementById('userPassword').value = "";
                document.getElementById('userPhone').value = row.children[4].innerText;
                document.getElementById('userDOB').value = row.children[5].innerText;
                document.getElementById('userCity').value = row.children[6].innerText;
                document.getElementById('userStreet').value = row.children[7].innerText;
                document.getElementById('userVisa').value = row.children[8].innerText;

                openUserForm(true);
                isEditMode = true;
            };
        });

        // حذف المستخدم
        document.querySelectorAll('.deleteUserBtn').forEach(btn => {
            btn.onclick = () => {
                if (confirm('هل تريد حذف هذا المستخدم؟')) {
                    fetch('adminphp/delete_user.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'id=' + encodeURIComponent(btn.dataset.id)
                    })
                        .then(res => res.text())
                        .then(response => {
                            if (response.includes("success")) {
                                alert("✔ تم حذف المستخدم");
                                loadUsers();
                            } else {
                                alert("❌ لم يتم الحذف!\n\nالسبب:\n" + response);
                            }
                        })
                        .catch(err => alert("خطأ في الاتصال:\n" + err));
                }
            };
        });
    }

    // ---------------- فتح الفورم كمودال ----------------
    function openUserForm(isEdit = false) {
        document.getElementById('userForm').style.display = 'block';
        document.getElementById('modalTitle').textContent = isEdit ? 'تعديل المستخدم' : 'إضافة مستخدم جديد';
        if (!isEdit) {
            ['userId','userName','userEmail','userPassword','userPhone','userDOB','userCity','userStreet','userVisa']
                .forEach(id => document.getElementById(id).value = '');
        }
    }


    // ---------------- إضافة مستخدم ----------------
    document.getElementById('addUserBtn').onclick = () => {
        openUserForm(false);
        isEditMode = false;
    };

    // ---------------- حفظ المستخدم (إضافة / تعديل) ----------------
    document.getElementById('saveUserBtn').onclick = () => {
        const id = document.getElementById('userId').value;
        const name = document.getElementById('userName').value;
        const email = document.getElementById('userEmail').value;
        const pass = document.getElementById('userPassword').value;
        const phone = document.getElementById('userPhone').value;
        const dob = document.getElementById('userDOB').value;
        const city = document.getElementById('userCity').value;
        const street = document.getElementById('userStreet').value;
        const visa = document.getElementById('userVisa').value;

        if (!id.trim()) {
            alert("⚠ يجب إدخال رقم الهوية!");
            return;
        }

        const url = isEditMode ? 'adminphp/edit_user.php' : 'adminphp/add_user.php';
        const data = `id=${encodeURIComponent(id)}&full_name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(pass)}&phone=${encodeURIComponent(phone)}&date_of_birth=${encodeURIComponent(dob)}&city=${encodeURIComponent(city)}&street=${encodeURIComponent(street)}&visa_number=${encodeURIComponent(visa)}`;

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: data
        })
            .then(res => res.text())
            .then(res => {
                if (res.trim() === "success") {
                    document.getElementById('userForm').style.display = 'none';
                    loadUsers();
                } else {
                    alert("خطأ أثناء الحفظ:\n" + res);
                }
            });
    };

    // ---------------- إلغاء ----------------
    document.getElementById('cancelUserBtn').onclick = () => {
        document.getElementById('userForm').style.display = 'none';
    };

    // ---------------- البحث ----------------
    const searchInput = document.querySelector(".topbar input");
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const text = this.value.trim();
            loadUsers(text);
        });
    }

    // تحميل أولي
    loadUsers();
}