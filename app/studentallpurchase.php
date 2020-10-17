<?php
session_start();


$studentid = NULL;
if ($_SESSION) {
    if ($_SESSION['role'] == "student") {
        $studentid = $_SESSION['id'];
    } else {
        header("Location: index.php");
    }
} else {
    echo "Session Is not there";
    header("Location: index.php");
}


include_once("config.php");


$start_date = NULL;
$end_date = NULL;

// if (isset($_GET['id'])) {
//     $studentid = $_GET['id'];
// }

if (isset($_GET['startdate'])) {
    $start_date = $_GET['startdate'];
}

if (isset($_GET['enddate'])) {
    $end_date = $_GET['enddate'];
}


$query_string =  query_builder($studentid, $start_date, $end_date);
$get_purchase = get_purchase_from_db($query_string);

$result_purchase = $get_purchase->fetchAll();
$json_string = json_encode($result_purchase);
//echo $json_string;


function query_builder($studentid, $start_date, $end_date)
{
    $base_query = "SELECT unit_purchase.id as parchase_id, unit_purchase.student as student_id, unit_purchase.date, student.first_name, student.last_name, student.email
    FROM unit_purchase, student
    WHERE unit_purchase.student = student.id";

    if ($studentid) {
        $base_query = $base_query . " AND student.id =" . $studentid;
    }

    if ($start_date) {
        $base_query = $base_query . " AND unit_purchase.date >='" . $start_date . "'";
    }

    if ($end_date) {
        $base_query = $base_query . " AND unit_purchase.date <='" . $end_date . "'";
    }

    return $base_query;
}

function get_purchase_from_db($query_string)
{
    $con = config::connect();
    $query = $con->prepare($query_string);

    $query->execute();
    return $query;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Purchases</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
</head>

<body>

    <h1>All Purchases</h1>

    <form align="right" name="form1" method="post" action="logout.php" style="position: fixed;right: 10px;top: 5px;">
        <label class="logoutLblPos">
            <?php echo ($_SESSION['role'] . " " . $_SESSION['id']); ?>
            <input name="submit2" type="submit" id="submit2" value="Log out" class="btn btn-danger">
        </label>
    </form>

    <div style="margin-bottom: 10px;">
        <a href="student.php">
            <button type="submit" class="btn btn-primary">Make New Purchase</button>
        </a>
        <a href="managestudent.php">
            <button type="submit" class="btn btn-primary">Students Manager</button>
        </a>
    </div>

    <div>
        <form action="?" method="GET" class="form-inline">
            <div class="form-group mx-sm-3 mb-2" style="display: none;">
                <label for="inputPassword2" class="sr-only">Student Id</label>
                <input type="text" class="form-control" id="inputPassword2" placeholder="Id" name="id">
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <label for="inputPassword2" class="sr-only">Start Date</label>
                <input type="date" class="form-control" id="inputPassword2" placeholder="Start Date" name="startdate">
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <label for="inputPassword2" class="sr-only">End Date</label>
                <input type="date" class="form-control" id="inputPassword2" placeholder="End Date" name="enddate">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Search</button>
        </form>
    </div>

    <div>
        <table id="myTable" class="table table-hover table-dark">
            <thead>
                <tr>
                    <th scope="col">Purchase Id</th>
                    <th scope="col">Student Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>

        </table>
    </div>

    <script>
        var s = <?php echo $json_string; ?>;
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

            var purchase_id = tempPur['parchase_id'];
            cell1.innerHTML = tempPur['parchase_id'];
            cell2.innerHTML = tempPur['student_id'];
            cell3.innerHTML = tempPur['first_name'] + " " + tempPur['last_name'];
            cell4.innerHTML = tempPur['date'];
            cell5.innerHTML = '<a href="purchasedetails.php?purchaseId=' + purchase_id + '"><button class="btn btn-primary btn-xs my-xs-btn" type="button" >' +
                '<span class="glyphicon glyphicon-print"></span> Detailed Report</button></a>';


        }
    </script>
</body>

</html>