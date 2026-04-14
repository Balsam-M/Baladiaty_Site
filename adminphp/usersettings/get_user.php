<?php
session_start();
include '../db.php';

if (!isset($conn)) {
    die("Connection not defined!");
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];

$sql = "SELECT full_name, email, phone, city, street, visa_number 
        FROM users 
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result()->fetch_assoc();

echo json_encode($result);
