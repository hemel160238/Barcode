<?php 
include_once("config.php");


if(isset($_POST['product'])){
    
    $product = $_POST['product'];
    $studentId = $_POST['studentId'];
    $cost = $_POST['cost'];

    $insertId = make_unit_purchase(($studentId));
    if($insertId){
        $result = make_array($insertId, $product);

        if($result){
            
            if(reduce_credit($studentId, $cost)){
                
                $conclusion = (object) array('result' => 1, 'insertId' => $insertId);
                echo(json_encode($conclusion));
            }
            else
            {
                $conclusion = (object) array('result' => 0, 'insertId' => null);
                echo(json_encode($conclusion));
            }
        }
        else{
            $conclusion = (object) array('result' => 0, 'insertId' => null);
            echo(json_encode($conclusion));
        }
    }

    else {
        $conclusion = (object) array('result' => 0, 'insertId' => null);
        echo(json_encode($conclusion));
    }    

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
    //echo($final_query);

    $con = config::connect();
    $query = $con->prepare($final_query);

    $query->execute();

    return $query;
}

function reduce_credit($studentId, $cost){
    
    $get_credit_string = "SELECT `credit` FROM `student` WHERE student.id = ".(string)$studentId;

    $con = config::connect();
    $query = $con->prepare($get_credit_string);
    $query->execute();
    $current_credit = (float)$query->fetchAll(PDO::FETCH_ASSOC)[0]['credit'];
    
    $new_credit = $current_credit - $cost;

    $update_credit_string = "UPDATE `student` SET `credit`=$new_credit WHERE student.id = ".(string)$studentId;

    $update_query = $con->prepare($update_credit_string);
    $update_query->execute();

    return $update_query;
}
?>
