<?php

if (isset($_POST["getStudent"])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $credit = $_POST['credit'];
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

    <title>Make Purchase</title>
</head>


<body>

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
        <input id="productIn" type="text" class="form-control" name="productId" placeholder="Product Id">
        <button type="button" id="addItemButton" onclick="myFunction()" class="btn btn-success">Add To
            Basket</button>
        <button type="button" id="calcPrice" onclick="calcPrice()" class="btn btn-success">Calculate Price</button>
    </div>

    <div>
        <table id="myTable" class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">Name</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Qty2</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>

            <!-- <tfoot>
                <tr>
                    <td>Total Cost</td>
                </tr>
            </tfoot> -->
        </table>

        <!-- <table class="table table-dark" id="resultTable">
            <thead>
                <tr>
                    <th scope="col">Total</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"><input id="" class="form-control" type="number" value="1" min="0" name="productId" placeholder="Qty" style="width: auto;"></th>
                    <th scope="col">Total Price</th>
                    <th scope="col"></th>
                </tr>
            </thead>
        </table> -->
    </div>

    <script>
        var input = document.getElementById("productIn");

        window.onload = function() {
            document.getElementById("disabledTextInputId").value = "<?php echo $id ?>";
            document.getElementById("disabledTextInputName").value = "<?php echo $name ?>";
            document.getElementById("disabledTextInputEmail").value = "<?php echo $email ?>";
            document.getElementById("disabledTextInputCredit").value = "<?php echo $credit ?>";
        };

        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("addItemButton").click();
                document.getElementById("productIn").value = "";
            }
        });

        function myFunction() {
            var productId = document.getElementById("productIn").value;

            var http = new XMLHttpRequest();
            var url = 'basket.php';
            var params = 'productId=' + productId;
            http.open('POST', url, true);

            //Send the proper header information along with the request
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            http.onreadystatechange = function() { //Call a function when the state changes.
                if (http.readyState == 4 && http.status == 200) {

                    var response = http.responseText;
                    var obj = JSON.parse(response)[0];

                    if (!obj) {
                        alert("Item Not Found!");
                    }

                    if (document.getElementById(obj['id']) !== null) {

                        var infield = document.getElementById(obj['id'])["childNodes"][4]["childNodes"][0];
                        var currentVal = parseInt(infield.value);
                        currentVal += 1;
                        infield.value = currentVal;


                    } else {
                        var table = document.getElementById("myTable");
                        var row = table.insertRow(table.rows.length);
                        row.id = obj['id'];
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        var cell5 = row.insertCell(4);

                        var calcPrice = row.insertCell(5);
                        var cell6 = row.insertCell(6);

                        cell1.innerHTML = obj['id'];
                        cell2.innerHTML = obj['price'];
                        cell3.innerHTML = obj['name'];
                        cell4.innerHTML = obj['qty'];

                        calcPrice.innerHTML = "Hello";
                        //cell5.innerHTML = '<input id="productIn" type="number" value="1" min="0" name="productId" placeholder="Qty">   <button type="button" onclick="removeItem(id)">Remove Item</button>'
                        cell5.innerHTML = '<input id="productNumber" class="form-control" type="number" value="1" min="0" name="productId" placeholder="Qty" style="width: auto;">'
                        cell6.innerHTML = '<button type="button" class="btn btn-danger" onclick="removeItem(this)">Remove Item</button>'
                        // var button = document.getElementById(obj['id'])["childNodes"][4]["childNodes"][2];
                        // button.onclick = function() { removeItem(obj['id']); }


                    }

                }

            }
            http.send(params);
        }

        function removeItem(btn) {
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }

        function calcPrice() {
            var mytable = document.getElementById("myTable");

            var grandTotal = 0;
            for (var i = 1, row; row = mytable.rows[i]; i++) {
                //iterate through rows
                //rows would be accessed using the "row" variable assigned in the for loop
                //console.log(row);

                var price = parseFloat(row.cells[1].innerHTML);
                //var qty = row.cells[4].innerHTML.value;

                //var totalprice = price*qty;
                //console.log(price);

                var prodCount = parseInt(document.getElementById(row['id'])["childNodes"][4]["childNodes"][0].value);

                row.cells[5].innerHTML = price * prodCount;

                var rowPrice = price * prodCount;
                grandTotal += rowPrice;

                for (var j = 0, col; col = row.cells[j]; j++) {
                    //iterate through columns
                    //columns would be accessed using the "col" variable assigned in the for loop
                }

            }

            var countText = mytable.rows[0].cells[5];
            countText.innerHTML = "Total Price =" + grandTotal;

            var creditAvaiable = parseFloat( document.getElementById("disabledTextInputCredit").value);

            if (creditAvaiable < grandTotal){
                document.getElementById("disabledTextInputCredit").style.border = "3px solid red";
            }
            else{
                document.getElementById("disabledTextInputCredit").style.border = "";
            }

        }
    </script>
</body>

</html>