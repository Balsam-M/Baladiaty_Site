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
    $searchQuery = "WHERE id LIKE '%$search%' OR content LIKE '%$search%'";
}

// جلب الإعلانات
$sql = "SELECT id, content, created_at 
        FROM announcements
        $searchQuery
        ORDER BY id DESC";

$result = $conn->query($sql);

echo '<table class="styled-table">';
echo '<thead>
        <tr>
            <th>#</th>
            <th>محتوى الإعلان</th>
            <th>تاريخ الإنشاء</th>
            <th>العمليات</th>
        </tr>
      </thead>
      <tbody>';

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['content']}</td>
                <td>{$row['created_at']}</td>
                <td>
                    <button class='btn btn-warning btn-sm editAnnouncementBtn' data-id='{$row['id']}'>
                       <i class='bi bi-pencil-square'></i> تعديل
                  </button>
                    <button class='btn btn-danger btn-sm deleteAnnouncementBtn' data-id='{$row['id']}'>
                      <i class='bi bi-trash'></i> حذف
                    </button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4' class='no-data'>لا توجد إعلانات</td></tr>";
}

echo '</tbody></table>';
?>