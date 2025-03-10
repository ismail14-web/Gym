<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $place = $_POST['place'];
    $payment_date = $_POST['payment_date'];
    $payment_status = $_POST['payment_status'];
    $payment_duration = $_POST['payment_duration'];

    // Update member details
    $stmt = $conn->prepare("UPDATE members SET name = ?, place = ? WHERE id = ?");
    $stmt->execute([$name, $place, $id]);

    // Insert payment details
    $stmt = $conn->prepare("INSERT INTO payments (member_id, payment_date, payment_status, payment_duration) 
                            VALUES (?, ?, ?, ?)");
    $stmt->execute([$id, $payment_date, $payment_status, $payment_duration]);

    header("Location: index.php");
    exit;
}
?>