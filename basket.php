<?php
session_start();
include_once("config.php");

$productId = NULL;

if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];
    //echo $productId;
}

// if (isset($_GET['productId'])) {
//     $productId = $_GET['productId'];
// }

$get_purchase = get_item($productId);

$result_purchase = $get_purchase->fetchAll();
$json_string = json_encode($result_purchase);

echo $json_string;
//SELECT * FROM `product` WHERE id = 1010 

function get_item($productId)
{
    $con = config::connect();
    $query_string = "SELECT * FROM `product` WHERE id = ".$productId;
    $query = $con->prepare($query_string);

    $query->execute();
    return $query;
}

?>