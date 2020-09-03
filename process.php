<?php
session_start();

include_once("config.php");

if(isset($_POST['register']))
{
    $con = config::connect();
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(insertStudent($con,$id, $first_name, $last_name, $email, $password))
    {
        $_SESSION['studentid'] = $id;
        $_SESSION['userType'] = 'student';
        header("Location: profile.php");
    }
}

function insertStudent($con,$id, $first_name, $last_name, $email, $password) 
{
    $query = $con->prepare("
    INSERT INTO student (id, first_name, last_name, email, password)

    VALUES(:id, :first_name, :last_name, :email, :password)
    ");

    $query->bindParam(":id", $id);
    $query->bindParam(":first_name", $first_name);
    $query->bindParam(":last_name", $last_name);
    $query->bindParam(":email", $email);
    $query->bindParam(":password", $password);

    return $query->execute();
}
?>