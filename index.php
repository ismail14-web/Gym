<?php
include 'db.php';
$stmt = $conn->prepare("SELECT m.id, m.name, m.place, p.payment_date, p.payment_status, p.payment_duration, 
                        DATE_ADD(p.payment_date, INTERVAL p.payment_duration MONTH) AS payment_end_date
                        FROM members m 
                        LEFT JOIN payments p ON m.id = p.member_id 
                        ORDER BY m.id, p.payment_date DESC");
$stmt->execute();
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sport time</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Sport time</h1>
        <a href="add_member.php" class="button add">Add Member</a>
        <table class="members-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Place</th>
                    <th>Payment Date</th>
                    <th>Payment End Date</th>
                    <th>Payment Status</th>
                    <th>Payment Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $current_member_id = null;
                foreach ($members as $member): 
                    if ($current_member_id !== $member['id']):
                        if ($current_member_id !== null): ?>
                            </ul></td></tr>
                        <?php endif; 
                        $current_member_id = $member['id']; ?>
                        <tr>
                            <td><?php echo htmlspecialchars($member['name']); ?></td>
                            <td><?php echo htmlspecialchars($member['place']); ?></td>
                            <td><?php echo htmlspecialchars($member['payment_date']); ?></td>
                            <td><?php echo htmlspecialchars($member['payment_end_date']); ?></td>
                            <td class="<?php echo $member['payment_status'] == 'Paid' ? 'paid' : 'not-paid'; ?>">
                                <?php echo htmlspecialchars($member['payment_status']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($member['payment_duration']); ?> Months</td>
                            <td class="actions">
                                <a href="delete_member.php?id=<?php echo $member['id']; ?>" class="button delete">Delete</a>
                                <a href="edit_member.php?id=<?php echo $member['id']; ?>" class="button edit">Edit</a>
                                <a href="payment_history.php?id=<?php echo $member['id']; ?>" class="button history">History</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>