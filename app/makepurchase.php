<?php 
include_once("config.php");


if(isset($_POST['product'])){
    
    $product = $_POST['product'];
    $studentId = $_POST['studentId'];
    //$insertId = make_unit_purchase(($studentId));

    // if($insertId){

    // }

    // else {
    //     echo "Error";
    // }
    make_array(2, $product);

}

function make_unit_purchase($studentId){

    $con = config::connect();
    $query_string = "INSERT INTO `unit_purchase`(`student`, `date`) VALUES ($studentId,NOW())";
    $query = $con->prepare($query_string);

    $query->execute();

    if($query){
        return $con->lastInsertId();
    }
    else{
        return null;
    }

}

function make_array($insertId, $product){
    $productArray = json_decode($product);
    //echo sizeof($productArray);

    $base_string = "INSERT INTO `all_purchase`(`purchase_id`, `item_id`, `qty`) VALUES ";
    $query_array = array();
    foreach($productArray as $product){
        $unit_insert_string = "(".$insertId.",".$product->id.",".$product->qty.")";
        array_push($query_array, $unit_insert_string);
    }
    $final_query = $base_string.implode(",", $query_array).";";
    echo($final_query);
}

function make_all_purchase($insertId, $product){

}
?>
