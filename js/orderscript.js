// ----------------------------
// Orders Page Script
// ----------------------------

const ordersBtn = document.querySelector('[data-page="orders"]');
if (ordersBtn) {
    ordersBtn.addEventListener('click', function () {
        loadPage('orders', 'adminphp/orderstable/orders.php', initOrders);
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        document.getElementById('orders').classList.add('active');
    });
}

function initOrders() {
    let isEditMode = false;

    function loadOrders(search = "") {
        fetch('adminphp/orderstable/get_orders.php?search=' + encodeURIComponent(search))
            .then(res => res.text())
            .then(html => {
                document.getElementById('ordersTable').innerHTML = html;
                attachOrderEvents();
            });
    }

    function attachOrderEvents() {
        document.querySelectorAll('.editOrderBtn').forEach(btn => {
            btn.onclick = () => {
                const row = btn.parentElement.parentElement;

                // تعبئة الفورم بقيم الصف
                document.getElementById('orderId').value = row.children[0].innerText; // الحقل المخفي للـ id
                document.getElementById('orderUserId').value = row.children[1].innerText;
                document.getElementById('orderDocumentType').value = row.children[2].innerText;
                document.getElementById('orderDetails').value = row.children[3].innerText;
                document.getElementById('orderStatus').value = row.children[4].innerText;

                openOrderForm(true);
                isEditMode = true;
            };
        });

        document.querySelectorAll('.deleteOrderBtn').forEach(btn => {
            btn.onclick = () => {
                if (confirm('هل تريد حذف هذا الطلب؟')) {
                    fetch('adminphp/orderstable/delete_order.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'id=' + encodeURIComponent(btn.dataset.id)
                    }).then(res => res.text())
                        .then(response => {
                            if (response.includes("success")) {
                                alert("✔ تم حذف الطلب");
                                loadOrders();
                            } else {
                                alert("❌ لم يتم الحذف!\n" + response);
                            }
                        });
                }
            };
        });
    }

    function openOrderForm(isEdit = false) {
        document.getElementById('orderForm').style.display = 'block';
        document.getElementById('modalTitleForm').textContent = isEdit ? 'تعديل الطلب' : 'إضافة طلب جديد';
        if (!isEdit) {
            ['orderId','orderUserId','orderDocumentType','orderDetails','orderStatus'].forEach(id => document.getElementById(id).value = '');
        }
    }

    document.getElementById('addOrderBtn').onclick = () => {
        openOrderForm(false);
        isEditMode = false;
    };

    document.getElementById('saveOrderBtn').onclick = () => {
        const id = document.getElementById('orderId').value; // مهم للـ edit
        const userId = document.getElementById('orderUserId').value;
        const docType = document.getElementById('orderDocumentType').value;
        const details = document.getElementById('orderDetails').value;
        const status = document.getElementById('orderStatus').value;

        if (!userId.trim()) {
            alert("⚠ يجب إدخال رقم المستخدم!");
            return;
        }

        const url = isEditMode ? 'adminphp/orderstable/edit_order.php' : 'adminphp/orderstable/add_order.php';
        const data = `id=${encodeURIComponent(id)}&user_id=${encodeURIComponent(userId)}&document_type=${encodeURIComponent(docType)}&details=${encodeURIComponent(details)}&status=${encodeURIComponent(status)}`;

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: data
        }).then(res => res.text())
            .then(res => {
                if (res.trim() === "success") {
                    document.getElementById('orderForm').style.display = 'none';
                    loadOrders();
                } else {
                    alert("خطأ أثناء الحفظ:\n" + res);
                }
            });
    };

    document.getElementById('cancelOrderBtn').onclick = () => {
        document.getElementById('orderForm').style.display = 'none';
    };

    const searchInput = document.querySelector(".topbar input");
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            loadOrders(this.value.trim());
        });
    }

    loadOrders();
}
