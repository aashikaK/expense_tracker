<?php
require 'db.php';

$success = false; // To track if update succeeded

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $date = $_POST['date'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];

    try{
        $sql = "UPDATE expenses SET date=?, category=?, amount=?, description=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$date, $category, $amount, $description, $id]);
        $success = true; // mark update as successful
    } catch(PDOException $e){
        $error = $e->getMessage();
    }
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM expenses WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $expense = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$expense){
        echo "Expense not found!";
        exit;
    }
} else {
    echo "No expense ID provided!";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Expense</title>
    <style>
        body { background: #d8c4fdff; font-family: sans-serif; }
        form { width: 400px; margin: 5rem auto; background:#e3d3ffff; padding: 2rem; border-radius: 10px; }
        input, button { width: 100%; padding: 0.7rem; margin: 0.5rem 0; border-radius: 5px; border:1px solid #aaa; }
        button { background:#b378f7ff; color:white; border:none; cursor:pointer; }
        .success { color: green; text-align: center; margin-bottom: 1rem; font-weight:bold; }
        .error { color: red; text-align: center; margin-bottom: 1rem; font-weight:bold;}
    </style>
</head>
<body>

    <form method="POST" action="">
        <h2 style="text-align:center;">Edit Expense</h2>

        <?php if(isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php elseif($success): ?>
            <p class="success"> Expense updated successfully!</p>
            <script>
                // Auto-redirect to view_expense.php after 2 seconds
                setTimeout(function(){
                    window.location.href = 'view_expense.php';
                }, 1300);
            </script>
        <?php endif; ?>

        <input type="hidden" name="id" value="<?php echo $expense['id']; ?>">

        <label>Date:</label>
        <input type="date" name="date" value="<?php echo $expense['date']; ?>" required>

        <label>Category:</label>
        <input type="text" name="category" value="<?php echo $expense['category']; ?>" required>

        <label>Amount:</label>
        <input type="number" name="amount" value="<?php echo $expense['amount']; ?>" required>

        <label>Description:</label>
        <input type="text" name="description" value="<?php echo $expense['description']; ?>" required>

        <button type="submit" name="update">Update Expense</button>
    </form>

</body>
</html>
