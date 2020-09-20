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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"
        defer></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"
        defer></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"
        defer></script>
    <title>Choose Student</title>
</head>

<body>

    <div>
        <form align="right" name="form1" method="post" action="logout.php" style="position: fixed;right: 10px;top: 5px;">
            <label class="logoutLblPos">
                <?php echo ($_SESSION['role']." ".$_SESSION['id']);?>
                <input name="submit2" type="submit" id="submit2" value="Log out" class="btn btn-danger">
            </label>
        </form>
    </div>



    <div>
        <input type="text" id="fname" name="fname" placeholder="Student Id" class="form-control">
        <div>
            <span><button type="button" id="addStudentButton" onclick="getStudentInfo()" class="btn btn-success">Select
                    Student</button></span>
            <span><button type="button" id="deleteStudentButton" onclick="removeStudent()" class="btn btn-danger">Delete
                    Student</button></span>
        </div>
    </div>

    <div>
        <form id="studentForm" action="./nothing.php" method="POST">
            <fieldset disabled style="display: flex;justify-content: space-around;">
                <div class="form-group">
                    <label for="disabledTextInput">Id</label>
                    <input type="text" id="disabledTextInputId" class="form-control" placeholder="ID" name="id">
                </div>
                <div class="form-group">
                    <label for="disabledTextInput">Name</label>
                    <input type="text" id="disabledTextInputName" class="form-control" placeholder="Name" name="name">
                </div>
                <div class="form-group">
                    <label for="disabledTextInput">Email</label>
                    <input type="text" id="disabledTextInputEmail" class="form-control" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                    <label for="disabledTextInput">Credit</label>
                    <input type="text" id="disabledTextInputCredit" class="form-control" placeholder="Credit" name="credit">
                </div>
            </fieldset>
        </form>
        <button type="submit" form="hiddenForm" value="Submit" name="getStudent">Submit</button>

    </div>

    <div style="display: none;">
        <form action="./nothing.php" id="hiddenForm" method="POST">
            <input type="text" id="hdisabledTextInputId" class="form-control" placeholder="ID" name="id">
            <input type="text" id="hdisabledTextInputName" class="form-control" placeholder="Name" name="name">
            <input type="text" id="hdisabledTextInputEmail" class="form-control" placeholder="Email" name="email">
            <input type="text" id="hdisabledTextInputCredit" class="form-control" placeholder="Credit" name="credit">
        </form>
        
    </div>

    <script>
        var inputStudent = document.getElementById("fname");


        inputStudent.addEventListener("keyup", function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("addStudentButton").click();
                document.getElementById("fname").value = "";
            }
        });
        function removeStudent() {
            document.getElementById("disabledTextInputId").value = "";
            document.getElementById("disabledTextInputName").value = "";
            document.getElementById("disabledTextInputEmail").value = "";
            document.getElementById("disabledTextInputCredit").value = "";
        }
        function getStudentInfo() {
            var studentId = document.getElementById("fname").value;
            var http = new XMLHttpRequest();
            var url = 'student2.php';
            var params = 'studentId=' + studentId;
            http.open('POST', url, true);

            //Send the proper header information along with the request
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            http.onreadystatechange = function () {//Call a function when the state changes.
                if (http.readyState == 4 && http.status == 200) {

                    var response = http.responseText;
                    var obj = JSON.parse(response)[0];

                    console.log(obj);
                    document.getElementById("disabledTextInputId").value = obj['id'];
                    document.getElementById("hdisabledTextInputId").value = obj['id'];

                    document.getElementById("disabledTextInputName").value = obj['first_name'] + " " + obj["last_name"];
                    document.getElementById("hdisabledTextInputName").value = obj['first_name'] + " " + obj["last_name"];

                    document.getElementById("disabledTextInputEmail").value = obj['email'];
                    document.getElementById("hdisabledTextInputEmail").value = obj['email'];

                    document.getElementById("disabledTextInputCredit").value = obj['credit'];
                    document.getElementById("hdisabledTextInputCredit").value = obj['credit'];

                }

            }
            http.send(params);
        }

    </script>
</body>

</html>