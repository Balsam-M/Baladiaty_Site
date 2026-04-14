const announcementsBtn = document.querySelector('[data-page="ads"]'); // تأكدي data-page="ads" في sidebar
if (announcementsBtn) {
    announcementsBtn.addEventListener('click', function () {
        loadPage('announcements', 'adminphp/announcements/announcements.php', initAnnouncements);
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        document.getElementById('announcements').classList.add('active');
    });
}

function initAnnouncements() {
    let isEditMode = false;

    function loadAnnouncements(search = "") {
        fetch('adminphp/announcements/get_announcements.php?search=' + encodeURIComponent(search))
            .then(res => res.text())
            .then(html => {
                document.getElementById('announcementsTable').innerHTML = html;
                attachAnnouncementEvents();
            });
    }

    function attachAnnouncementEvents() {
        document.querySelectorAll('.editAnnouncementBtn').forEach(btn => {
            btn.onclick = () => {
                const row = btn.parentElement.parentElement;
                document.getElementById('announcementId').value = row.children[0].innerText;
                document.getElementById('announcementContent').value = row.children[1].innerText;
                openAnnouncementForm(true);
                isEditMode = true;
            };
        });

        document.querySelectorAll('.deleteAnnouncementBtn').forEach(btn => {
            btn.onclick = () => {
                if (confirm('هل تريد حذف هذا الإعلان؟')) {
                    fetch('adminphp/announcements/delete_announcement.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'id=' + encodeURIComponent(btn.dataset.id)
                    }).then(res => res.text())
                        .then(response => {
                            if (response.includes("success")) {
                                alert("✔ تم حذف الإعلان");
                                loadAnnouncements();
                            } else {
                                alert("❌ لم يتم الحذف!\n" + response);
                            }
                        });
                }
            };
        });
    }

    function openAnnouncementForm(isEdit = false) {
        document.getElementById('announcementForm').style.display = 'block';
        document.getElementById('modalTitleForm').textContent = isEdit ? 'تعديل الإعلان' : 'إضافة إعلان جديد';
        if (!isEdit) {
            ['announcementId','announcementContent'].forEach(id => document.getElementById(id).value = '');
        }
    }

    document.getElementById('addAnnouncementBtn').onclick = () => {
        openAnnouncementForm(false);
        isEditMode = false;
    };

    document.getElementById('saveAnnouncementBtn').onclick = () => {
        const id = document.getElementById('announcementId').value;
        const content = document.getElementById('announcementContent').value.trim();

        if (!content) {
            alert("⚠ يجب إدخال محتوى الإعلان!");
            return;
        }

        const url = isEditMode ?
            'adminphp/announcements/edit_announcement.php' :
            'adminphp/announcements/add_announcement.php';
        const data = `id=${encodeURIComponent(id)}&content=${encodeURIComponent(content)}`;

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: data
        }).then(res => res.text())
            .then(res => {
                if (res.trim() === "success") {
                    document.getElementById('announcementForm').style.display = 'none';
                    loadAnnouncements();
                } else {
                    alert("خطأ أثناء الحفظ:\n" + res);
                }
            });
    };

    document.getElementById('cancelAnnouncementBtn').onclick = () => {
        document.getElementById('announcementForm').style.display = 'none';
    };

    const searchInput = document.querySelector(".topbar input");
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            loadAnnouncements(this.value.trim());
        });
    }

    loadAnnouncements();
}