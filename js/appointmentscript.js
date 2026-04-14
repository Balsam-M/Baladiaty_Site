// ----------------------------
// Appointments Page Script
// ----------------------------

const appointmentsBtn = document.querySelector('[data-page="appointments"]');

if (appointmentsBtn) {
    appointmentsBtn.addEventListener('click', function () {
        loadPage('appointments', 'adminphp/appointmentstable/appointments.php', initAppointments);
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        document.getElementById('appointments').classList.add('active');
    });
}

function initAppointments() {
    let isEditMode = false;

    function loadAppointments(search = "") {
        fetch('adminphp/appointmentstable/get_appointments.php?search=' + encodeURIComponent(search))
            .then(res => res.text())
            .then(html => {
                document.getElementById('appointmentsTable').innerHTML = html;
                attachAppointmentEvents();
            });
    }

    function attachAppointmentEvents() {
        // أزرار التعديل
        document.querySelectorAll('.editAppointmentBtn').forEach(btn => {
            btn.onclick = () => {
                const row = btn.parentElement.parentElement;
                document.getElementById('appointmentId').value = row.children[0].innerText;
                document.getElementById('appointmentUserId').value = row.children[1].innerText;
                document.getElementById('appointmentDate').value = row.children[2].innerText;
                document.getElementById('appointmentTime').value = row.children[3].innerText;
                document.getElementById('appointmentServiceType').value = row.children[4].innerText;
                document.getElementById('appointmentStatus').value = row.children[5].innerText;

                openAppointmentForm(true);
                isEditMode = true;
            };
        });

        // أزرار الحذف
        document.querySelectorAll('.deleteAppointmentBtn').forEach(btn => {
            btn.onclick = () => {
                if (confirm('هل تريد حذف هذا الموعد؟')) {
                    fetch('adminphp/appointmentstable/delete_appointments.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'id=' + encodeURIComponent(btn.dataset.id)
                    }).then(res => res.text())
                        .then(response => {
                            if (response.includes("success")) {
                                alert("✔ تم حذف الموعد");
                                loadAppointments();
                            } else {
                                alert("❌ لم يتم الحذف!\n" + response);
                            }
                        });
                }
            };
        });
    }

    function openAppointmentForm(isEdit = false) {
        document.getElementById('appointmentForm').style.display = 'block';
        document.getElementById('appointmentModalTitleForm').textContent = isEdit ? 'تعديل الموعد' : 'إضافة موعد جديد';
        if (!isEdit) {
            ['appointmentId','appointmentUserId','appointmentDate','appointmentTime','appointmentServiceType','appointmentStatus'].forEach(id => {
                document.getElementById(id).value = '';
            });
        }
    }

    document.getElementById('addAppointmentBtn').onclick = () => {
        openAppointmentForm(false);
        isEditMode = false;
    };

    document.getElementById('saveAppointmentBtn').onclick = () => {
        const id = document.getElementById('appointmentId').value;
        const userId = document.getElementById('appointmentUserId').value;
        const date = document.getElementById('appointmentDate').value;
        const time = document.getElementById('appointmentTime').value;
        const service = document.getElementById('appointmentServiceType').value;
        const status = document.getElementById('appointmentStatus').value;

        if (!userId.trim() || !date.trim()) {
            alert("⚠ يجب إدخال رقم المستخدم والتاريخ!");
            return;
        }

        const url = isEditMode ? 'adminphp/appointmentstable/edit_appointments.php' : 'adminphp/appointmentstable/add_appointments.php';
        const data = `id=${encodeURIComponent(id)}&user_id=${encodeURIComponent(userId)}&appointment_date=${encodeURIComponent(date)}&appointment_time=${encodeURIComponent(time)}&service_type=${encodeURIComponent(service)}&status=${encodeURIComponent(status)}`;

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: data
        }).then(res => res.text())
            .then(res => {
                if (res.trim() === "success") {
                    document.getElementById('appointmentForm').style.display = 'none';
                    loadAppointments();
                } else {
                    alert("خطأ أثناء الحفظ:\n" + res);
                }
            });
    };

    document.getElementById('cancelAppointmentBtn').onclick = () => {
        document.getElementById('appointmentForm').style.display = 'none';
    };

    // البحث الديناميكي
    const searchInput = document.querySelector(".topbar input");
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            loadAppointments(this.value.trim());
        });
    }

    // تحميل أولي
    loadAppointments();
}
