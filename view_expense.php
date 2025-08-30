<?php
require "db.php";
$sql="SELECT * FROM expenses ORDER BY date DESC";
$stmt=$pdo->prepare($sql);
$stmt->execute();
$expenses= $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Expenses</title>
    <style>
        body{background: #d8c4fdff;}
        table { border-collapse: collapse; width: 80%; margin: 2rem auto; font-size: 1.3rem; margin-top:3rem;}
        th, td { border: 0.2rem solid #444; padding: 0.8rem; text-align: center; background:#e3d3ffff; }
        th { background-color: #b378f7ff; }
        button { cursor: pointer; }
    </style>
</head>
<body>
    <h2 style="text-align:center; margin-top:6rem;">Expense List</h2>
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
</body>
</html>
