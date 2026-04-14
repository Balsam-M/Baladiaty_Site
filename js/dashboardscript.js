let ordersChart = null;
let billsChart = null;

// تحميل البيانات عند أول تحميل الصفحة
document.addEventListener('DOMContentLoaded', () => {
    loadDashboardCounts();
});

function loadDashboardCounts() {
    fetch('adminphp/dashboard.php')
        .then(res => res.json())
        .then(data => {

            // عرض الأرقام
            document.getElementById('usersCount').textContent = data.users;
            document.getElementById('ordersCount').textContent = data.orders;
            document.getElementById('billsCount').textContent = data.bills;
            document.getElementById('appointmentsCount').textContent = data.appointments;

            // رسم التشارتات
            drawOrdersChart(data.users, data.orders);
            drawBillsChart(data.users, data.bills);

            // تحديث جدول آخر الإعلانات
            const adsTable = document.getElementById('latest-ads');
            adsTable.innerHTML = ''; // نفضي الجدول أولاً
            data.latest_ads.forEach(ad => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${ad.id}</td>
                    <td>${ad.content}</td>
                    <td>${ad.created_at}</td>
                `;
                adsTable.appendChild(tr);
            });

        })
        .catch(err => {
            console.error(err);
            alert('فشل تحميل بيانات الداشبورد');
        });
}


// رسم تشارت نسبة الطلبات إلى المستخدمين
function drawOrdersChart(users, orders) {
    if (ordersChart) ordersChart.destroy();
    ordersChart = new Chart(document.getElementById('ordersUsersChart'), {
        type: 'doughnut',
        data: {
            labels: ['الطلبات', 'بدون طلبات'],
            datasets: [{
                data: [orders, Math.max(users - orders, 0)],
                backgroundColor: ['#ac6532', '#eaeaea'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',   // يخلي الدونات أنحف
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        font: { size: 12 }
                    }
                }
            }
        }
    });
}

function drawBillsChart(users, bills) {
    if (billsChart) billsChart.destroy();
    billsChart = new Chart(document.getElementById('billsUsersChart'), {
        type: 'doughnut',
        data: {
            labels: ['الفواتير', 'بدون فواتير'],
            datasets: [{
                data: [bills, Math.max(users - bills, 0)],
                backgroundColor: ['#2f4156', '#eaeaea'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        font: { size: 12 }
                    }
                }
            }
        }
    });
}


// عند الضغط على زر Dashboard في السايدبار
const dashboardBtn = document.querySelector('[data-page="dashboard"]');
if (dashboardBtn) {
    dashboardBtn.addEventListener('click', () => {

        // إظهار الداشبورد
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        document.getElementById('dashboard').classList.add('active');

        // 🔥 تحديث الأرقام + التشارتات
        loadDashboardCounts();
    });
}
