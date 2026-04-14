<?php
session_start();
include '../db.php';
if (!isset($conn)) {
    die("Connection not defined!");
}

$userId = $_SESSION['user_id'];

$full_name = $_POST['full_name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$city = $_POST['city'] ?? '';
$street = $_POST['street'] ?? '';
$visa_number = $_POST['visa_number'] ?? '';

$sql = "UPDATE users SET
full_name=?, email=?, phone=?, city=?, street=?, visa_number=?
WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssi",
    $full_name,
    $email,
    $phone,
    $city,
    $street,
    $visa_number,
    $userId
);

echo json_encode([
    "status" => $stmt->execute() ? "success" : "error"
]);
