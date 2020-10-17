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

$insert_success = "unset";
$update_success = "unset";

if (isset($_POST['submit-btn'])) {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $credit = $_POST['credit'];

    $insert_result = insertStudent($id, $first_name, $last_name, $email, $password, $credit);

    if ($insert_result) {
        $insert_success = "true";
    } else {
        $insert_success = "false";
    }
} else {
    
}


function insertStudent($id, $first_name, $last_name, $email, $password, $credit)
{

    try {
        $con = config::connect();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query_string = "INSERT INTO `student` (`id`, `first_name`, `last_name`, `email`, `password`, `credit`) VALUES ('$id', '$first_name', '$last_name', '$email', '$password', '$credit')";
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
    <title>Add Student</title>
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

                <li class="nav-item active">
                    <a class="nav-link" href="addstudent.php">Add Student</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="additem.php">Add Item</a>
                </li>
            </ul>
        </div>
    </nav>

    <div id="rootDiv">

    <?php 
    
        if($insert_success == "true"){

            echo '<div class="alert alert-success" id="success_div">';
            echo '<strong>Operation Successful!</strong> Student Inserted Successfully' ;
            echo '</div>';
        }
        elseif ($insert_success == "false"){
            echo '<div class="alert alert-danger" id="success_div">';
            echo '<strong>Operation Failed!</strong> Check Your Inserted Data Again' ;
            echo '</div>';
        }
    
    ?>

        <!-- <div class="alert alert-success" id="success_div" style="visibility: hidden;">
            <strong>Success!</strong> Indicates a successful or positive action.
        </div> -->


        <h1>Add Students</h1>

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
                    <label for="exampleInputEmail1">First Name</label>
                    <input type="text" class="form-control" id="fnameInput" aria-describedby="emailHelp" placeholder="First Name" name="first_name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Last Name</label>
                    <input type="text" class="form-control" id="lnameInput" aria-describedby="emailHelp" placeholder="Last Name" name="last_name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="emailInput" aria-describedby="emailHelp" placeholder="Enter email" name="email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="text" class="form-control" id="passInput" placeholder="Password" name="password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Credit</label>
                    <input type="text" class="form-control" id="creditInput" placeholder="Credit" name="credit">
                </div>
                <input type="submit" class="btn btn-primary" name="submit-btn">
            </form>
        </div>

    </div>
    <script>


        function addStudent() {

            var id = document.getElementById('idInput').value;
            var first_name = document.getElementById('fnameInput').value;
            var last_name = document.getElementById('lnameInput').value;
            var email = document.getElementById('emailInput').value;
            var password = document.getElementById('passInput').value;
            var action = "add";
            alert(id + first_name + last_name + email + password);


            var http = new XMLHttpRequest();
            var url = 'addoreditstudent.php';
            var params = 'id=' + id + "&first_name=" + first_name + "&last_name=" + last_name + "$email=" + email + "&password=" + password + "&action=" + action;
            http.open('POST', url, true);

            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            http.onreadystatechange = function() { //Call a function when the state changes.
                if (http.readyState == 4 && http.status == 200) {

                    var response = http.responseText;
                    //var obj = JSON.parse(response)[0];
                    console.log(response);

                    console.log(response);


                }

            }
            http.send(params);
        }
    </script>
</body>

</html>