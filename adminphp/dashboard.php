<?php
include 'db.php';
if (!isset($conn)) {
    die("فشل الاتصال بقاعدة البيانات!");
}

// مصفوفة الرد
$response = [
    "users" => 0,
    "orders" => 0,
    "bills" => 0,
    "appointments" => 0,
    "latest_ads" => []
];

// عدد المستخدمين
$q = $conn->query("SELECT COUNT(*) c FROM users");
$response['users'] = $q->fetch_assoc()['c'];

// عدد الطلبات
$q = $conn->query("SELECT COUNT(*) c FROM requests");
$response['orders'] = $q->fetch_assoc()['c'];

// عدد الفواتير
$q = $conn->query("SELECT COUNT(*) c FROM bills");
$response['bills'] = $q->fetch_assoc()['c'];

// عدد المواعيد
$q = $conn->query("SELECT COUNT(*) c FROM appointments");
$response['appointments'] = $q->fetch_assoc()['c'];

// آخر 3 إعلانات
$q = $conn->query("SELECT id, content, created_at FROM announcements ORDER BY id DESC LIMIT 6");
$response['latest_ads'] = [];
if($q) {
    while ($row = $q->fetch_assoc()) {
        $response['latest_ads'][] = $row;
    }
}


// إرجاع JSON
echo json_encode($response);
?>
