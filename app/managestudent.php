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
    <title>Add Student</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
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

                <li class="nav-item active">
                    <a class="nav-link" href="managestudent.php">Manage Student<span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="addstudent.php">Add Student</a>
                </li>

            </ul>
        </div>
    </nav>
    <div id="rootDiv">

        <h1>Add Student</h1>

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
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Credit</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>


    <script>
        var editClicked = [];
        var s = <?php echo $json_string; ?>;

        for (let key in s) {
            var tempPur = s[key];

            var table = document.getElementById("myTable");
            var row = table.insertRow(table.rows.length);
            row.id = tempPur['id'];
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);

            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var cell7 = row.insertCell(6);

            var student_id = tempPur['id'];

            cell1.innerHTML = tempPur['id'];
            cell2.innerHTML = tempPur['first_name'];
            cell3.innerHTML = tempPur['last_name'];
            cell4.innerHTML = tempPur['email'];
            cell5.innerHTML = tempPur['credit'];

            cell6.innerHTML = '<a href="managestudent.php?deleteStudent=' + student_id + '"><button class="btn btn-danger btn-xs my-xs-btn" type="button" >' +
                '<span class="glyphicon glyphicon-trash"></span>Delete</button></a>';
            cell7.innerHTML = '<button class="btn btn-warning btn-xs my-xs-btn" type="button" onclick="activateEditField(' + tempPur['id'] + ')">Edit</button>';


        }

        function activateEditField(rowId) {
            var table = document.getElementById(rowId);

            if (!editClicked.includes(rowId)) {

                editClicked.push(rowId);

                for (var i = 0, cell; cell = table.cells[i]; i++) {
                    if (i == 1 || i == 2 || i == 3 || i == 4) {
                        cell.innerHTML = '<input id="row_'+i+'" type="text" value =' + cell.innerHTML + '></input>';
                    }
                }

                var editButtonCell = table.cells[6];
                editButtonCell.innerHTML = '<button class="btn btn-success btn-xs my-xs-btn" type="button" onclick="activateEditField(' + rowId + ')">Save</button>';
            } else {


                const index = editClicked.indexOf(rowId);
                if (index > -1) {
                    editClicked.splice(index, 1);
                }

                for (var i = 0, cell; cell = table.cells[i]; i++) {
                    if (i == 1 || i == 2 || i == 3 || i == 4) {

                        var cellValue = document.getElementById('row_'+i).value;
                        

                        var tableInput = createElementFromHTML(cell.innerHTML);
                        cell.innerHTML = cellValue;
                    }
                }

                var editButtonCell = table.cells[6];
                editButtonCell.innerHTML = '<button class="btn btn-warning btn-xs my-xs-btn" type="button" onclick="activateEditField(' + rowId + ')">Edit</button>';
                updateValue(table.cells[0].innerHTML, table.cells[1].innerHTML, table.cells[2].innerHTML, table.cells[3].innerHTML, table.cells[4].innerHTML);

            }

        }

        function createElementFromHTML(htmlString) {
            var div = document.createElement('div');
            div.innerHTML = htmlString.trim();

            // Change this to div.childNodes to support multiple top-level nodes
            return div.firstChild;
        }

        function updateValue(id, fname, lname, email, credit) {
            console.log(id + fname + lname + email + credit);

            var http = new XMLHttpRequest();
            var url = 'updatestudent.php';
            var params = 'id='+id+'&fname='+fname+'&lname='+lname+'&email='+email+'&credit='+credit;

            http.open('POST', url, true);

            //Send the proper header information along with the request
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            http.onreadystatechange = function() { //Call a function when the state changes.
                if (http.readyState == 4 && http.status == 200) {
                    //alert(http.responseText);
                    
                }
            }
            http.send(params);
        }

        function noSubmit(){
            return true;
        }
    </script>
</body>

</html>