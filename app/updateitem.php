<?php
session_start();

if ($_SESSION) {
    if ($_SESSION['role'] == "admin") {
    } else {
        header("Location: login.html");
    }
} else {
    echo "Session Is not there";
    header("Location: login.html");
}

include_once("config.php");

$id = $_POST['id'];
$price = $_POST['price'];
$name = $_POST['name'];
$qty = $_POST['qty'];

if(updateStudent($id, $price, $name, $qty)){
    //echo "Success";
}
else {
    //echo "Failed!";
}

function updateStudent($id, $price, $name, $qty){

    $con = config::connect();
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query_string = "UPDATE `product` SET `price` = '$price', `name` = '$name', `qty` = '$qty' WHERE `product`.`id` = '$id'";
    $query = $con->prepare($query_string);

    $query->execute();
    return $query;
}

?>