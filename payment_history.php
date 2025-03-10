<?php
include 'db.php';

$member_id = $_GET['id'];
$stmt = $conn->prepare("SELECT m.name, m.place, p.payment_date, p.payment_status, p.payment_duration, 
                        DATE_ADD(p.payment_date, INTERVAL p.payment_duration MONTH) AS payment_end_date
                        FROM members m 
                        LEFT JOIN payments p ON m.id = p.member_id 
                        WHERE m.id = ?
                        ORDER BY p.payment_date DESC");
$stmt->execute([$member_id]);
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
$member = $payments[0];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment History</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Payment History for <?php echo htmlspecialchars($member['name']); ?></h1>
        <a href="index.php" class="button back">Back to Members List</a>
        <table class="members-table">
            <thead>
                <tr>
                    <th>Payment Date</th>
                    <th>Payment End Date</th>
                    <th>Payment Status</th>
                    <th>Payment Duration</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                    <td><?php echo htmlspecialchars($payment['payment_end_date']); ?></td>
                    <td class="<?php echo $payment['payment_status'] == 'Paid' ? 'paid' : 'not-paid'; ?>">
                        <?php echo htmlspecialchars($payment['payment_status']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($payment['payment_duration']); ?> Months</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>