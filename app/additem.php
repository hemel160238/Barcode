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

$insert_success = "unset";
$update_success = "unset";

if (isset($_POST['submit-btn'])) {
    $id = $_POST['id'];
    $price = $_POST['price'];
    $name = $_POST['name'];
    $qty = $_POST['qty'];

    $insert_result = insertItem($id, $price, $name, $qty);

    if ($insert_result) {
        $insert_success = "true";
    } else {
        $insert_success = "false";
    }
} else {
    
}


function insertItem($id, $price, $name, $qty)
{

    try {
        $con = config::connect();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query_string = "INSERT INTO `product` (`id`, `price`, `name`, `qty`) VALUES ('$id', '$price', '$name', '$qty')";
        $query = $con->exec($query_string);

        return true;
    } catch (PDOException $e) {

        return false;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
    <title>Add Item</title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #e3f2fd;">
        <a class="navbar-brand" href="allpurchase.php">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item">
                    <a class="nav-link" href="student.php">Make Purchase</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="managestudent.php">Manage Student</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="manageitem.php">Manage Item</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="addstudent.php">Add Student</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="additem.php">Add Item</a>
                </li>

            </ul>
        </div>
    </nav>

    <div id="rootDiv">

    <?php 
    
        if($insert_success == "true"){

            echo '<div class="alert alert-success" id="success_div">';
            echo '<strong>Operation Successful!</strong> Item Inserted Successfully' ;
            echo '</div>';
        }
        elseif ($insert_success == "false"){
            echo '<div class="alert alert-danger" id="success_div">';
            echo '<strong>Operation Failed!</strong> Check Your Inserted Data Again' ;
            echo '</div>';
        }
    
    ?>

        <h1>Add Item</h1>

        <form align="right" name="form1" method="post" action="logout.php" style="position: fixed;right: 10px;top: 5px;">
            <label class="logoutLblPos">
                <?php echo ($_SESSION['role'] . " " . $_SESSION['id']); ?>
                <input name="submit2" type="submit" id="submit2" value="Log out" class="btn btn-danger">
            </label>
        </form>

        <div id="formDiv">
            <form action="?" method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Id</label>
                    <input type="text" class="form-control" id="idInput" aria-describedby="emailHelp" placeholder="Enter ID" name="id">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Price</label>
                    <input type="text" class="form-control" id="priceInput" aria-describedby="emailHelp" placeholder="Unit Price" name="price">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" id="nameInput" aria-describedby="emailHelp" placeholder="Item Name" name="name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Qty</label>
                    <input type="text" class="form-control" id="qtyInput" aria-describedby="emailHelp" placeholder="Quantity" name="qty">
                </div>
    
                <input type="submit" class="btn btn-primary" name="submit-btn">
            </form>
        </div>

    </div>
    <script>

    </script>
</body>

</html>