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
    echo $query_string;
    $query = $con->prepare($query_string);

    $query->execute();
    return $query;
}

?>