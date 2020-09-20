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

if(isset($_POST['login']))
{
    $con = config::connect();
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];


    $loginResult = checkLogin($con, $role, $email, $password);

    if($loginResult[0]){
        $user_info =$loginResult[1]->fetchAll()[0];

        $_SESSION['role'] = $role;
        $_SESSION['id'] = $user_info['id'];
        $_SESSION['first_name'] = $user_info['first_name'];
        $_SESSION['last_name'] = $user_info['last_name'];
        $_SESSION['email'] = $user_info['email'];

        if($role == "student"){
            $_SESSION['credit'] = $user_info['credit'];
        }

        if ($role == "admin"){
            header("Location: allpurchase.php");
        }

        var_dump($_SESSION);
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

function checkLogin($con, $role, $email, $password){

    if($role == "admin"){
        $query = $con->prepare("
        SELECT * 
        FROM `admin`
        WHERE email =:email AND password =:password
    ");

    $query->bindParam(":email", $email);
    $query->bindParam(":password", $password);

    $query->execute();

    if($query->rowCount() == 1){

        $result = array();
        array_push($result, true);
        array_push($result, $query);
        return $result;
    }
    else{
        $result = array();
        array_push($result, false);
        return $result;
    }

    }

    elseif($role == 'student'){
        $query = $con->prepare("
        SELECT * 
        FROM `student`
        WHERE email =:email AND password =:password
    ");

    $query->bindParam(":email", $email);
    $query->bindParam(":password", $password);

    $query->execute();

    if($query->rowCount() == 1){

        $result = array();
        array_push($result, true);
        array_push($result, $query);
        return $result;
    }
    else{
        $result = array();
        array_push($result, false);
        return $result;
    }
    }


    
}
?>
