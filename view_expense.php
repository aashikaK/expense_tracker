<?php
require "db.php";
$sql="SELECT * FROM expenses ORDER BY date DESC";
$stmt=$pdo->prepare($sql);
$stmt->execute();
$expenses= $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalSql = "SELECT SUM(amount) as total_amount FROM expenses";
$totalStmt = $pdo->prepare($totalSql);
$totalStmt->execute();
$totalResult = $totalStmt->fetch(PDO::FETCH_ASSOC);
$totalAmount = $totalResult['total_amount'] ?? 0; // 0 if no expenses


// Total by category
$categorySql = "SELECT category, SUM(amount) as total FROM expenses GROUP BY category";
$categoryStmt = $pdo->prepare($categorySql);
$categoryStmt->execute();
$categoryTotals = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <title>My Expenses</title>
    <style>
        body{background: #d8c4fdff;}
        table { border-collapse: collapse; width: 80%; margin: 2rem auto; font-size: 1.3rem; margin-top:2rem;}
        th, td { border: 0.2rem solid #444; padding: 0.8rem; text-align: center; background:#e3d3ffff; }
        th { background-color: #b378f7ff; }
        button { cursor: pointer; }
    </style>
</head>
<body>
    <h2 style="text-align:center; margin-top:3rem;">Expense List</h2>
    <h3>Total Expenses: Rs <?= $totalAmount ?></h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    
        <?php if(count($expenses) > 0): ?>
            <?php foreach($expenses as $row): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['date'] ?></td>
                    <td><?= $row['category'] ?></td>
                    <td><?= $row['amount'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td>
                        <!-- Delete Form -->
                        <form method="POST" action="delete_expense.php" onsubmit="return confirm('Are you sure?')">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" style="background:red; color:white; border:none; padding:5px 10px; border-radius:5px;">
                                Delete
                            </button>
                        </form>

                        <!-- Edit Form -->
                        <form method="GET" action="edit_expense.php" style="margin-top:5px;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" style="background:blue; color:white; border:none; padding:5px 10px; border-radius:5px;">
                                Edit
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">No expenses found</td></tr>
        <?php endif; ?>
    </table>

    <h3 style="text-align:center; color:#4f46e5; margin-top:2rem; font-weight:bold; font-size:1.6rem">Total by Category</h3>
<table style="width:50%; margin:1rem auto; border:1px solid #444; border-collapse:collapse;">
    <tr style="background:#b378f7ff; color:white;">
        <th>Category</th>
        <th>Total Amount (Rs)</th>
    </tr>
    <?php foreach($categoryTotals as $cat): ?>
    <tr style="background:#e3d3ffff; text-align:center;">
        <td><?= $cat['category'] ?></td>
        <td><?= $cat['total'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
