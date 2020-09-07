
        // Get the input field
        var input = document.getElementById("productIn");


        // Execute a function when the user releases a key on the keyboard
        input.addEventListener("keyup", function (event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
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

            http.onreadystatechange = function () {//Call a function when the state changes.
                if (http.readyState == 4 && http.status == 200) {

                    var response = http.responseText;
                    var obj = JSON.parse(response)[0];

                    if (document.getElementById(obj['id']) !== null) {

                        var infield = document.getElementById(obj['id'])["childNodes"][4]["childNodes"][0];
                        var currentVal = parseInt(infield.value);
                        currentVal += 1;
                        infield.value = currentVal;


                    }
                    else {
                        var table = document.getElementById("myTable");
                        var row = table.insertRow(table.rows.length);
                        row.id = obj['id'];
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        var cell5 = row.insertCell(4);
                        var cell6 = row.insertCell(5);
                        cell1.innerHTML = obj['id'];
                        cell2.innerHTML = obj['price'];
                        cell3.innerHTML = obj['name'];
                        cell4.innerHTML = obj['qty'];
                        //cell5.innerHTML = '<input id="productIn" type="number" value="1" min="0" name="productId" placeholder="Qty">   <button type="button" onclick="removeItem(id)">Remove Item</button>'
                        cell5.innerHTML = '<input id="productNumber" class="form-control" type="number" value="1" min="0" name="productId" placeholder="Qty">'
                        cell6.innerHTML = '<button type="button" class="btn btn-danger" onclick="removeItem(this)">Remove Item</button>'
                        // var button = document.getElementById(obj['id'])["childNodes"][4]["childNodes"][2];
                        // button.onclick = function() { removeItem(obj['id']); }
                    }

                }
            }
            http.send(params);
        }

        function getStudentInfo(btn) {
            var studentId = document.getElementById("studentId").value;

            //console.log(btn);

            var http = new XMLHttpRequest();
            var url = 'student.php';
            var params = 'studentId=' + studentId;
            http.open('POST', url, true);

            //Send the proper header information along with the request
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            http.onreadystatechange = function () {//Call a function when the state changes.
                if (http.readyState == 4 && http.status == 200) {

                    var response = http.responseText;
                    var obj = JSON.parse(response)[0];

                    console.log(obj);

                }
            }
            http.send(params);
        }

        function removeItem(btn) {
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }