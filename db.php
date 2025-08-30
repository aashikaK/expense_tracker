<?php
$host="localhost";
$db="expense_tracker";
$username="root";
$password="";
try{
    $pdo= new PDO("mysql:host=$host;dbname=$db",$username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo "Connected successsfully";
}
catch(PDOException $e){
    echo "Connection failed". $e->getMessage();
}
?>