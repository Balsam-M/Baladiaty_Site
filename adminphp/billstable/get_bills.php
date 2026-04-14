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
        bill_type LIKE '%$search%' OR
        total_amount LIKE '%$search%' OR
        billing_date LIKE '%$search%'";
}

// جلب الفواتير
$sql = "SELECT id, user_id, bill_type, total_amount, billing_date 
        FROM bills
        $searchQuery
        ORDER BY id DESC";

$result = $conn->query($sql);

echo '<table class="styled-table">';
echo '<thead>
        <tr>
            <th>#</th>
            <th>رقم المستخدم</th>
            <th>نوع الفاتورة</th>
            <th>المبلغ الإجمالي</th>
            <th>تاريخ الفاتورة</th>
            <th>العمليات</th>
        </tr>
      </thead>
      <tbody>';

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['user_id']}</td>
                <td>{$row['bill_type']}</td>
                <td>{$row['total_amount']}</td>
                <td>{$row['billing_date']}</td>
                <td>
                    <button class='btn btn-warning btn-sm editBillBtn' data-id='{$row['id']}'>
                        <i class='bi bi-pencil-square'></i> تعديل
                    </button>
                    <button class='btn btn-danger btn-sm deleteBillBtn' data-id='{$row['id']}'>
                        <i class='bi bi-trash'></i> حذف
                    </button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6' class='no-data'>لا توجد فواتير</td></tr>";
}

echo '</tbody></table>';
?>
