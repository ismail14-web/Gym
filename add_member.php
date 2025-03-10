<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $place = $_POST['place'];
    $payment_date = $_POST['payment_date'];
    $payment_status = $_POST['payment_status'];
    $payment_duration = $_POST['payment_duration'];

    // Insert member details
    $stmt = $conn->prepare("INSERT INTO members (name, place) VALUES (?, ?)");
    $stmt->execute([$name, $place]);

    // Get the last inserted member ID
    $member_id = $conn->lastInsertId();

    // Insert payment details
    $stmt = $conn->prepare("INSERT INTO payments (member_id, payment_date, payment_status, payment_duration) 
                            VALUES (?, ?, ?, ?)");
    $stmt->execute([$member_id, $payment_date, $payment_status, $payment_duration]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Member</title>
    <link rel="stylesheet" href="css/add.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h2>Add New Member</h2>
            <a href="index.php" class="back-btn">Back</a>
        </div>
        <form action="add_member.php" method="POST" class="member-form">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required class="input-field">
            </div>
            <div class="form-group">
                <label for="place">Place</label>
                <input type="text" id="place" name="place" required class="input-field">
            </div>
            <div class="form-group">
                <label for="payment_date">Payment Date</label>
                <input type="date" id="payment_date" name="payment_date" required class="input-field">
            </div>
            <div class="form-group">
                <label for="payment_duration">Payment Duration</label>
                <select name="payment_duration" id="payment_duration" class="select-field" required>
                    <option value="1">1 Month</option>
                    <option value="3">3 Months</option>
                    <option value="6">6 Months</option>
                    <option value="12">12 Months</option>
                </select>
            </div>
            <div class="form-group">
                <label for="payment_status">Payment Status</label>
                <select id="payment_status" name="payment_status" required class="select-field">
                    <option value="Paid">Paid</option>
                    <option value="Not Paid">Not Paid</option>
                </select>
            </div>
            <div class="button-group">
                <button type="submit" class="btn save-btn">Save Member</button>
                <a href="index.php" class="btn cancel-btn">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>