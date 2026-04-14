<?php
session_start();
include 'db.php';

if (!isset($conn)) {
    die("Connection not defined!");
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success'=>false,'message'=>'يجب تسجيل الدخول']);
    exit;
}

$user_id = $_SESSION['user_id'];
$text = $_POST['text'] ?? '';
$rating = $_POST['rating'] ?? 0;

if ($text == '' || $rating < 1 || $rating > 5) {
    echo json_encode(['success'=>false,'message'=>'بيانات غير صحيحة']);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO feedback (user_id, text, rating) VALUES (?, ?, ?)"
);
$stmt->bind_param("isi", $user_id, $text, $rating);
$stmt->execute();

echo json_encode(['success'=>true]);
