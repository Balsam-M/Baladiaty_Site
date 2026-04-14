<?php
include '../db.php';
if (!isset($conn)) {
    die("Connection not defined!");
}

// الحصول على نص البحث
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// إنشاء شرط البحث
$searchQuery = "";
if (!empty($search)) {
    $searchQuery = "WHERE 
        id LIKE '%$search%' OR
        user_id LIKE '%$search%' OR
        title LIKE '%$search%' OR
        description LIKE '%$search%' OR
        status LIKE '%$search%'";
}

// جلب الشكاوى
$sql = "SELECT id, user_id, title, description, status, created_at 
        FROM complaints
        $searchQuery
        ORDER BY id DESC";

$result = $conn->query($sql);

// خريطة تحويل الحالة من إنجليزي → عربي
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
            <th>عنوان الشكوى</th>
            <th>التفاصيل</th>
            <th>الحالة</th>
            <th>تاريخ الإنشاء</th>
            <th>العمليات</th>
        </tr>
      </thead>
      <tbody>';

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        // تحويل الحالة إلى العربية
        $status_ar = $status_map[$row['status']] ?? $row['status'];

        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['user_id']}</td>
                <td>{$row['title']}</td>
                <td>{$row['description']}</td>
                <td>{$status_ar}</td>
                <td>{$row['created_at']}</td>
                <td>
                    <button class='btn btn-warning btn-sm editComplaintBtn' data-id='{$row['id']}'>
                        <i class='bi bi-pencil-square'></i> تعديل
                    </button>
                    <button class='btn btn-danger btn-sm deleteComplaintBtn' data-id='{$row['id']}'>
                        <i class='bi bi-trash'></i> حذف
                    </button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='7' class='no-data'>لا توجد شكاوى</td></tr>";
}

echo '</tbody></table>';
?>
