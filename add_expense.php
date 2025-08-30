<?php
require 'db.php';  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Expenses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #d8c4fdff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background:#e3d3ffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.4);
            width: 350px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            color: #444;
        }

        input[type="text"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }
        select {
    width: 106.4%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    background: white;
    cursor: pointer;
    transition: 0.3s;
}

input[type="text"]:hover, input[type="date"]:hover, input[type="number"]:hover,select:hover {
    border-color: #4f46e5; /* same as button hover color */
}

select:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 5px rgba(79, 70, 229, 0.5);
}

        button {
            width: 100%;
            padding: 12px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #4338ca;
        }

        .success {
            color: green;
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 15px;
             font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Expense</h2>
        <form action="" method="POST">
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" required>

            <label for="category">Category:</label>
<select name="category" id="category" required>
    <option value="">--Select Category--</option>
    <option value="Clothes">Clothes</option>
    <option value="Shoes">Shoes</option>
    <option value="Bills">Bills</option>
    <option value="Fees">Fees</option>
    <option value="Groceries">Groceries</option>
    <option value="Food">Food</option>
    <option value="Transport">Transport</option>
    <option value="Health">Health</option>
    <option value="Entertainment">Entertainment</option>
    <option value="Gifts">Gifts</option>
    <option value="Miscellaneous">Miscellaneous</option>
</select>

            <label for="amount">Amount:</label>
            <input type="number" name="amount" id="amount" placeholder="e.g. 500" required>

            <label for="des">Description:</label>
            <input type="text" name="desc" id="des" placeholder="e.g. Lunch with friends" required>

            <button type="submit" name="btn_add">Add Expense</button>
        </form>
        <?php
        if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["btn_add"])){
            $date=$_POST["date"];
            $category = $_POST['category'];
            $amount = $_POST['amount'];
            $description = $_POST['desc'];
            try{
                $sql ="insert into expenses(date,category,amount,description) values(?,?,?,?)";
                $stmt=$pdo->prepare($sql);
                $stmt->execute([$date,$category,$amount,$description]);
                echo "<p class='success'> Expense details added successfully</p>";
            }
            catch(PDOException $e){
                echo "<p class='error'> Error: " .$e->getMessage()."</p>";
            }
        }
        ?>
    </div>
</body>
</html>
