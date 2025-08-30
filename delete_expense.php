<?php
require "db.php";

if(isset($_POST['id'])){
    $id=$_POST['id'];

    try{
    $sql= "delete from expenses where id= ?";
    $stmt=$pdo->prepare($sql);
    $stmt->eecute([$id]);
    header("Location:view_expense.php");
    exit;
    }
    catch(PDOException $e){
        echo "Error-> ".$e->getMessage();
    }else {
    // If no ID is sent, go back to table
    header("Location: view_expense.php");
    exit;
}
}