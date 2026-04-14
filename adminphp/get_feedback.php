<?php
session_start();
include 'db.php';
if (!isset($conn)) {
    die("Connection not defined!");
}

$query = "
    SELECT f.text, f.rating, f.created_at, u.full_name
    FROM feedback f
    LEFT JOIN users u ON f.user_id = u.id
    ORDER BY f.created_at DESC
";

$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
