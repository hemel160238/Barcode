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

$deleteStudent = NULL;

if (isset($_GET['deleteStudent'])) {
    $deleteStudent = $_GET['deleteStudent'];

    del_student($deleteStudent);
}

echo ($deleteStudent);

$get_purchase = get_student();

$result_purchase = $get_purchase->fetchAll();
$json_string = json_encode($result_purchase);

//echo $json_string;
//SELECT * FROM `product` WHERE id = 1010 
function del_student($deleteStudent)
{
    $con = config::connect();
    $query_string = "DELETE FROM student WHERE student.id = " . $deleteStudent;
    $query = $con->prepare($query_string);

    $query->execute();
    echo $query->rowCount();
    return $query;
}


function get_student()
{
    $con = config::connect();
    $query_string = "SELECT * FROM `student`";
    $query = $con->prepare($query_string);

    $query->execute();
    return $query;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div id="rootDiv">

        <h1>Manage Students</h1>

        <form align="right" name="form1" method="post" action="logout.php" style="position: fixed;right: 10px;top: 5px;">
            <label class="logoutLblPos">
                <?php echo ($_SESSION['role'] . " " . $_SESSION['id']); ?>
                <input name="submit2" type="submit" id="submit2" value="Log out" class="btn btn-danger">
            </label>
        </form>

        <div id="buttonDiv">
            <a href="addstudent.php">
                <button type="submit" class="btn btn-primary">Add Student</button>
            </a>
        </div>

        <div>
            <table id="myTable" class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">Student Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Credit</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>


    <script>
        var s = <?php echo $json_string; ?>;

        console.log(s);
        for (let key in s) {
            console.log(key);
            var tempPur = s[key];

            var table = document.getElementById("myTable");
            var row = table.insertRow(table.rows.length);
            row.id = tempPur['id'];
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);

            var cell5 = row.insertCell(4);

            var student_id = tempPur['id'];

            cell1.innerHTML = tempPur['id']
            cell2.innerHTML = tempPur['first_name'] + " " + tempPur['last_name'];
            cell3.innerHTML = tempPur['email'];
            cell4.innerHTML = tempPur['credit'];

            cell5.innerHTML = '<a href="managestudent.php?deleteStudent=' + student_id + '"><button class="btn btn-danger btn-xs my-xs-btn" type="button" >' +
                '<span class="glyphicon glyphicon-trash"></span>Delete</button></a>';


        }
    </script>
</body>

</html>