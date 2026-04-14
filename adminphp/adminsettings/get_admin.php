<?php
include '../db.php';

if (!isset($conn)) {
    die("Connection not defined!");
}

$adminId = 1111;

$sql = "SELECT id, full_name, email, phone, date_of_birth, city, street,visa_number
        FROM users
        WHERE id = $adminId
        LIMIT 1";

$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Admin not found"]);
}
?>