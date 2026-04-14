<?php
include 'db.php';
if (!isset($conn)) {
    die("Connection not defined!");
}

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$searchQuery = "";
if (!empty($search)) {
    $searchQuery = "WHERE 
        id LIKE '%$search%' OR
        full_name LIKE '%$search%' OR
        email LIKE '%$search%' OR
        phone LIKE '%$search%' OR
        city LIKE '%$search%' OR
        street LIKE '%$search%' OR
        visa_number LIKE '%$search%'";
}

$sql = "SELECT id, full_name, email, password, phone, date_of_birth, city, street, visa_number, created_at 
        FROM users
        $searchQuery
        ORDER BY id DESC";

$result = $conn->query($sql);

echo '<table class="styled-table">';
echo '<thead>
        <tr>
            <th>#</th>
            <th>الاسم</th>
            <th>الإيميل</th>
            <th>كلمة المرور</th>
            <th>الهاتف</th>
            <th>تاريخ الميلاد</th>
            <th>المدينة</th>
            <th>الشارع</th>
            <th>رقم الفيزا</th>
            <th>تاريخ الإنشاء</th>
            <th>العمليات</th>
        </tr>
      </thead>
      <tbody>';

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        // إخفاء الباسورد المشفر - نعرض نجوم بدلاً منه
        $maskedPassword = '••••••••';

        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['full_name']}</td>
                <td>{$row['email']}</td>
                <td>{$maskedPassword}</td>
                <td>{$row['phone']}</td>
                <td>{$row['date_of_birth']}</td>
                <td>{$row['city']}</td>
                <td>{$row['street']}</td>
                <td>{$row['visa_number']}</td>
                <td>{$row['created_at']}</td>
                <td>
                    <button class='btn btn-warning btn-sm editUserBtn' data-id='{$row['id']}'>
                        <i class='bi bi-pencil-square'></i> تعديل
                    </button>
                    <button class='btn btn-danger btn-sm deleteUserBtn' data-id='{$row['id']}'>
                        <i class='bi bi-trash'></i> حذف
                    </button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='11' class='no-data'>لا يوجد مستخدمين</td></tr>";
}

echo '</tbody></table>';
?>