<?php
include_once("config.php");

if (isset($_GET['purchaseId'])) {
    $purchaseId = $_GET['purchaseId'];

    $result = get_purchase_details($purchaseId);
    $result_purchase = $result->fetchAll();
    $json_string = json_encode($result_purchase);

    echo ($json_string);
} else {
    echo ("404 Not Found");
}

function get_purchase_details($purchaseId)
{

    $query_string = "SELECT unit_purchase.id, unit_purchase.date, all_purchase.item_id, all_purchase.qty, product.name, product.price, student.id, student.first_name, student.last_name, student.email, student.credit FROM unit_purchase, all_purchase, product, student WHERE unit_purchase.id = all_purchase.purchase_id AND all_purchase.item_id = product.id AND unit_purchase.student = student.id AND unit_purchase.id = $purchaseId";
    $con = config::connect();
    $query = $con->prepare($query_string);

    $query->execute();

    return $query;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous" defer></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous" defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js" async></script>
    <title>Document</title>
</head>

<body>

    <button type="button" id="makePurchase" onclick="print()" class="btn btn-success">Print</button>
    <div>
        <form>
            <fieldset disabled style="display: flex;justify-content: space-around;">
                <div class="form-group">
                    <label for="disabledTextInput">Id</label>
                    <input type="text" id="disabledTextInputId" class="form-control" placeholder="ID">
                </div>
                <div class="form-group">
                    <label for="disabledTextInput">Name</label>
                    <input type="text" id="disabledTextInputName" class="form-control" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="disabledTextInput">Email</label>
                    <input type="text" id="disabledTextInputEmail" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="disabledTextInput">Credit</label>
                    <input type="text" id="disabledTextInputCredit" class="form-control" placeholder="Credit">
                </div>
            </fieldset>
        </form>
    </div>
    <div>
        <table class="table">
            <tbody>
                <tr>
                    <th scope="row">Id</th>
                    <td id="tableid">Mark</td>
                </tr>
                <tr>
                    <th scope="row">Name</th>
                    <td id="tablename">Jacob</td>
                </tr>
                <tr>
                    <th scope="row">Email</th>
                    <td id="tableemail">Larry</td>
                </tr>
                <tr>
                    <th scope="row">Credit</th>
                    <td id="tablecredit">Larry</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <table id="myTable" class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Total Price</th>
                </tr>
            </thead>

            <!-- <tfoot>
                <tr>
                    <td>Total Cost</td>
                </tr>
            </tfoot> -->
        </table>
    </div>

    <script>
        var s = <?php echo $json_string; ?>;
        var totalCost = 0;



        for (let key in s) {
            //console.log(key, s[key]);
            var tempPur = s[key];
            document.getElementById("disabledTextInputId").value = tempPur['id'];
            document.getElementById("disabledTextInputName").value = tempPur['first_name'] + " " + tempPur['last_name'];
            document.getElementById("disabledTextInputEmail").value = tempPur['email'];
            document.getElementById("disabledTextInputCredit").value = tempPur['credit'];


            var table = document.getElementById("myTable");
            var row = table.insertRow(table.rows.length);
            row.id = tempPur['id'];
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);

            cell1.innerHTML = tempPur['item_id'];
            cell2.innerHTML = tempPur['name'];
            cell3.innerHTML = tempPur['price'];
            cell4.innerHTML = tempPur['qty'];
            cell5.innerHTML = parseFloat(tempPur['price']) * parseInt(tempPur['qty']);
            totalCost += parseFloat(tempPur['price']) * parseInt(tempPur['qty']);
        }

        var table = document.getElementById("myTable");
        var row = table.insertRow(table.rows.length);
        row.id = tempPur['id'];
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);

        cell1.innerHTML = "Total Cost";
        cell5.innerHTML = totalCost;


        function print() {
            var doc = new jsPDF();
            var elementHandler = {
                '#ignorePDF': function(element, renderer) {
                    return true;
                }
            };
            var source = window.document.getElementsByTagName("body")[0];
            doc.fromHTML(
                source,
                15,
                15, {
                    'width': 180,
                    'elementHandlers': elementHandler
                });

            doc.output("dataurlnewwindow");
        }
    </script>
</body>

</html>