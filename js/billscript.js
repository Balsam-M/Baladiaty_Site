const billsBtn = document.querySelector('[data-page="bills"]');
if (billsBtn) {
    billsBtn.addEventListener('click', function () {
        loadPage('bills', 'adminphp/billstable/bills.php', initBills);
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        document.getElementById('bills').classList.add('active');
    });
}

function initBills() {
    let isEditMode = false;

    function loadBills(search = "") {
        fetch('adminphp/billstable/get_bills.php?search=' + encodeURIComponent(search))
            .then(res => res.text())
            .then(html => {
                document.getElementById('billsTable').innerHTML = html;
                attachBillEvents();
            });
    }

    function attachBillEvents() {
        document.querySelectorAll('.editBillBtn').forEach(btn => {
            btn.onclick = () => {
                const row = btn.parentElement.parentElement;
                document.getElementById('billId').value = row.children[0].innerText;
                document.getElementById('billUserId').value = row.children[1].innerText;
                document.getElementById('billType').value = row.children[2].innerText;
                document.getElementById('billAmount').value = row.children[3].innerText;
                document.getElementById('billDate').value = row.children[4].innerText;
                document.getElementById('billForm').style.display = 'block';
                isEditMode = true;
            };
        });

        document.querySelectorAll('.deleteBillBtn').forEach(btn => {
            btn.onclick = () => {
                if (confirm('هل تريد حذف هذه الفاتورة؟')) {
                    fetch('adminphp/billstable/delete_bills.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'id=' + encodeURIComponent(btn.dataset.id)
                    })
                        .then(res => res.text())
                        .then(response => {
                            if (response.includes("success")) loadBills();
                            else alert("خطأ:\n" + response);
                        });
                }
            };
        });
    }

    document.getElementById('addBillBtn').onclick = () => {
        document.getElementById('billForm').style.display = 'block';
        ['billId','billUserId','billType','billAmount','billDate'].forEach(id => document.getElementById(id).value = "");
        isEditMode = false;
    };

    document.getElementById('saveBillBtn').onclick = () => {
        const id = document.getElementById('billId').value;
        const user_id = document.getElementById('billUserId').value;
        const type = document.getElementById('billType').value;
        const amount = document.getElementById('billAmount').value;
        const date = document.getElementById('billDate').value;

        const url = isEditMode ? 'adminphp/billstable/edit_bills.php' : 'adminphp/billstable/add_bills.php';
        let data = `user_id=${encodeURIComponent(user_id)}&bill_type=${encodeURIComponent(type)}&total_amount=${encodeURIComponent(amount)}&billing_date=${encodeURIComponent(date)}`;
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
                    document.getElementById('billId').value = newId;
                    document.getElementById('billForm').style.display = 'none';
                    loadBills();
                } else {
                    alert("خطأ أثناء الحفظ:\n" + res);
                }
            });
    };

    document.getElementById('cancelBillBtn').onclick = () => {
        document.getElementById('billForm').style.display = 'none';
    };

    const searchInput = document.querySelector(".topbar input");
    if (searchInput) searchInput.addEventListener("input", function () {
        loadBills(this.value.trim());
    });

    loadBills();
}
