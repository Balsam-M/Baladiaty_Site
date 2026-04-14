const complaintsBtn = document.querySelector('[data-page="complaints"]');
if (complaintsBtn) {
    complaintsBtn.addEventListener('click', function () {
        loadPage('complaints', 'adminphp/complaintstable/complaints.php', initComplaints);
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        document.getElementById('complaints').classList.add('active');
    });
}

function initComplaints() {
    let isEditMode = false;

    function loadComplaints(search = "") {
        fetch('adminphp/complaintstable/get_complaints.php?search=' + encodeURIComponent(search))
            .then(res => res.text())
            .then(html => {
                document.getElementById('complaintsTable').innerHTML = html;
                attachComplaintEvents();
            });
    }

    function attachComplaintEvents() {
        document.querySelectorAll('.editComplaintBtn').forEach(btn => {
            btn.onclick = () => {
                const row = btn.parentElement.parentElement;
                document.getElementById('complaintId').value = row.children[0].innerText;
                document.getElementById('complaintUserId').value = row.children[1].innerText;
                document.getElementById('complaintTitle').value = row.children[2].innerText;
                document.getElementById('complaintDescription').value = row.children[3].innerText;
                document.getElementById('complaintStatus').value = row.children[4].innerText;
                document.getElementById('complaintForm').style.display = 'block';
                isEditMode = true;
            };
        });

        document.querySelectorAll('.deleteComplaintBtn').forEach(btn => {
            btn.onclick = () => {
                if (confirm('هل تريد حذف هذه الشكوى؟')) {
                    fetch('adminphp/complaintstable/delete_complaints.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'id=' + encodeURIComponent(btn.dataset.id)
                    })
                        .then(res => res.text())
                        .then(response => {
                            if (response.includes("success")) loadComplaints();
                            else alert("خطأ:\n" + response);
                        });
                }
            };
        });
    }

    document.getElementById('addComplaintBtn').onclick = () => {
        document.getElementById('complaintForm').style.display = 'block';
        ['complaintId','complaintUserId','complaintTitle','complaintDescription','complaintStatus']
            .forEach(id => document.getElementById(id).value = "");
        isEditMode = false;
    };

    document.getElementById('saveComplaintBtn').onclick = () => {
        const id      = document.getElementById('complaintId').value;
        const user_id = document.getElementById('complaintUserId').value;
        const title   = document.getElementById('complaintTitle').value;
        const desc    = document.getElementById('complaintDescription').value;
        const status  = document.getElementById('complaintStatus').value;

        const url = isEditMode ? 'adminphp/complaintstable/edit_complaints.php'
            : 'adminphp/complaintstable/add_complaints.php';
        let data = `user_id=${encodeURIComponent(user_id)}&title=${encodeURIComponent(title)}&description=${encodeURIComponent(desc)}&status=${encodeURIComponent(status)}`;
        if (isEditMode) data = `id=${encodeURIComponent(id)}&` + data;

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: data
        })
            .then(res => res.text())
            .then(res => {
                if (res.startsWith("success")) {
                    const newId = res.split("|")[1] ?? id;
                    document.getElementById('complaintId').value = newId;
                    document.getElementById('complaintForm').style.display = 'none';
                    loadComplaints();
                } else {
                    alert("خطأ أثناء الحفظ:\n" + res);
                }
            });
    };

    document.getElementById('cancelComplaintBtn').onclick = () => {
        document.getElementById('complaintForm').style.display = 'none';
    };

    const searchInput = document.querySelector(".topbar input");
    if (searchInput) searchInput.addEventListener("input", function () {
        loadComplaints(this.value.trim());
    });

    loadComplaints();
}
