<?php
session_start();
include_once("config.php");

$studentId = NULL;

if (isset($_POST['studentId'])) {
    $studentId = $_POST['studentId'];
    //echo $studentId;
}
$get_purchase = get_student($studentId);

$result_purchase = $get_purchase->fetchAll();
$json_string = json_encode($result_purchase);

echo $json_string;
//SELECT * FROM `product` WHERE id = 1010 

function get_student($studentId)
{
    $con = config::connect();
    $query_string = "SELECT * FROM `student` WHERE id = ".$studentId;
    $query = $con->prepare($query_string);

    $query->execute();
    return $query;
}

?>