<?php
session_start();

if ($_SESSION) {
    if ($_SESSION['role'] == "admin") {
    } else {
        header("Location: index.php");
    }
} else {
    echo "Session Is not there";
    header("Location: index.php");
}

include_once("config.php");

$id = $_POST['id'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$credit = $_POST['credit'];

if(updateStudent($id, $fname, $lname, $email, $credit)){
    //echo "Success";
}
else {
    //echo "Failed!";
}

function updateStudent($id, $fname, $lname, $email, $credit){

    $con = config::connect();
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query_string = "UPDATE `student` SET `first_name` = '$fname', `last_name` = '$lname', `email` = '$email', `credit` = '$credit' WHERE `student`.`id` = '$id'";
    $query = $con->prepare($query_string);

    $query->execute();
    return $query;
}

?>