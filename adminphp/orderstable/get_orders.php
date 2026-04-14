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
        document_type LIKE '%$search%' OR
        details LIKE '%$search%' OR
        status LIKE '%$search%'";
}

// جلب الطلبات
$sql = "SELECT id, user_id, document_type, details, status, created_at 
        FROM requests
        $searchQuery
        ORDER BY id DESC";

$result = $conn->query($sql);

// خريطة تحويل الحالة من إنجليزي لعربي
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
            <th>نوع الوثيقة</th>
            <th>التفاصيل</th>
            <th>الحالة</th>
            <th>تاريخ الإنشاء</th>
            <th>العمليات</th>
        </tr>
      </thead>
      <tbody>';

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $status_ar = $status_map[$row['status']] ?? $row['status']; // تحويل إنجليزي → عربي

        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['user_id']}</td>
                <td>{$row['document_type']}</td>
                <td>{$row['details']}</td>
                <td>{$status_ar}</td>
                <td>{$row['created_at']}</td>
                <td>
                    <button class='btn btn-warning btn-sm editOrderBtn' data-id='{$row['id']}'>
                        <i class='bi bi-pencil-square'></i> تعديل
                    </button>
                    <button class='btn btn-danger btn-sm deleteOrderBtn' data-id='{$row['id']}'>
                        <i class='bi bi-trash'></i> حذف
                    </button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='7' class='no-data'>لا توجد طلبات</td></tr>";
}

echo '</tbody></table>';
?>
