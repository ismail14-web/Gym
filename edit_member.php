<?php
include 'db.php';
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM members WHERE id = ?");
$stmt->execute([$id]);
$member = $stmt->fetch(PDO::FETCH_ASSOC);
$paymentDuration = $member['payment_end_date'] ? floor((strtotime($member['payment_end_date']) - strtotime($member['payment_date'])) / (60 * 60 * 24 * 30)) : 1;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Member</title>
    <link rel="stylesheet" href="css/edit.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h2><i class="fas fa-user-edit"></i> Edit Member</h2>
            <a href="index.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        
        <form action="update_member.php" method="POST" class="member-form">
            <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
            <input type="hidden" name="payment_end_date" value="<?php echo $member['payment_end_date']; ?>">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo $member['name']; ?>" required class="input-field">
            </div>
            
            <div class="form-group">
                <label for="place">Place</label>
                <input type="text" id="place" name="place" value="<?php echo $member['place']; ?>" required class="input-field">
            </div>
            
            <div class="form-group">
                <label for="payment_date">Payment Date</label>
                <input type="date" id="payment_date" name="payment_date" value="<?php echo $member['payment_date']; ?>" required class="input-field">
            </div>

            <div class="form-group">
                <label for="payment_duration">Payment Duration</label>
                <select name="payment_duration" id="payment_duration" class="select-field" required>
                    <option value="1" <?php if ($paymentDuration == 1) echo 'selected'; ?>>1 Month</option>
                    <option value="3" <?php if ($paymentDuration == 3) echo 'selected'; ?>>3 Months</option>
                    <option value="6" <?php if ($paymentDuration == 6) echo 'selected'; ?>>6 Months</option>
                    <option value="12" <?php if ($paymentDuration == 12) echo 'selected'; ?>>12 Months</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Payment Status</label>
                <select name="payment_status" class="select-field">
                    <option value="Paid" <?php if($member['payment_status'] == 'Paid') echo 'selected'; ?>>Paid</option>
                    <option value="Not Paid" <?php if($member['payment_status'] == 'Not Paid') echo 'selected'; ?>>Not Paid</option>
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