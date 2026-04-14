<?php
include '../db.php';

if (!isset($conn)) {
    die("Connection not defined!");
}

// نص البحث
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// شرط البحث
$searchQuery = "";
if (!empty($search)) {
    $searchQuery = "WHERE 
        id LIKE '%$search%' OR
        user_id LIKE '%$search%' OR
        service_type LIKE '%$search%' OR
        status LIKE '%$search%'";
}

// جلب المواعيد
$sql = "SELECT id, user_id, appointment_date, appointment_time, service_type, status, created_at
        FROM appointments
        $searchQuery
        ORDER BY id DESC";

$result = $conn->query($sql);

// خريطة الحالة عربي
$status_map = [
    'pending'  => 'قيد الانتظار',
    'approved' => 'موافق عليه',
    'rejected' => 'مرفوض'
];

echo '<table class="styled-table">';
echo '<thead>
        <tr>
            <th>#</th>
            <th>رقم المستخدم</th>
            <th>التاريخ</th>
            <th>الوقت</th>
            <th>نوع الخدمة</th>
            <th>الحالة</th>
            <th>تاريخ الإنشاء</th>
            <th>العمليات</th>
        </tr>
      </thead>
      <tbody>';

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $status_ar = $status_map[$row['status']] ?? $row['status'];

        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['user_id']}</td>
                <td>{$row['appointment_date']}</td>
                <td>{$row['appointment_time']}</td>
                <td>{$row['service_type']}</td>
                <td>{$status_ar}</td>
                <td>{$row['created_at']}</td>
                <td>
                    <button class='btn btn-warning btn-sm editAppointmentBtn' data-id='{$row['id']}'>
                        <i class='bi bi-pencil-square'></i> تعديل
                    </button>
                    <button class='btn btn-danger btn-sm deleteAppointmentBtn' data-id='{$row['id']}'>
                        <i class='bi bi-trash'></i> حذف
                    </button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='8' class='no-data'>لا توجد مواعيد</td></tr>";
}

echo '</tbody></table>';
?>
