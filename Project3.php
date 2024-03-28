<?php
////// Write the Database connection code below (Q1)
$servername = 'localhost';
$username = 'root'; 
$password = ''; 
$database = "food list"; 

// Create connection
$link = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

///////// (Q1 Ends)

$operation_val = '';
if (isset($_POST['operation'])) {
    $operation_val = $_POST["operation"];
}

function getId($link) {
    $queryMaxID = "SELECT MAX(id) FROM fooditems_1;";
    $resultMaxID = mysqli_query($link, $queryMaxID);
    $row = mysqli_fetch_array($resultMaxID, MYSQLI_NUM);
    return $row[0] + 1;
}

if (isset($_POST['updatebtn'])) 
{//// Write PHP Code below to update the record of your database (Hint: Use $_POST) (Q9)
//// Make sure your code has an echo statement that says "Record Updated" or anything similar or an error message
    
    $id = $_POST['id'];
    $name = $_POST['name']; 
    $price = $_POST['price'];
    
    $query = "UPDATE fooditems_1 SET name='$newName', price='$newPrice' WHERE id=$id";
    
    if (mysqli_query($link, $query)) {
        echo "Record Updated";
    } else {
        echo "Error updating record: " . mysqli_error($link);
    }

//// (Q9 Ends)
}

if (isset($_POST['insertbtn'])) {//// Write PHP Code below to insert the record into your database (Hint: Use $_POST and the getId() function from line 25, if needed) (Q10)
//// Make sure your code has an echo statement that says "Record Saved" or anything similar or an error message
    if (isset($_POST['insertbtn'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $id = getId($link);

        $query = "INSERT INTO fooditems_1 (id, name, price) VALUES ($id, '$name', '$price')";
    
        if (mysqli_query($link, $query)) {
            echo "Record Saved";
        } else {
            echo "Error saving record: " . mysqli_error($link);
        }
    } 
    //// (Q10 Ends)
}

if (isset($_POST['deletebtn'])) {
    //// Write PHP Code below to delete the record from your database (Hint: Use $_POST) (Q11)
    
    $id = $_POST['id_to_delete'];
    
    $query = "DELETE FROM fooditems_1 WHERE id = $id";
    
    if (mysqli_query($link, $query)) {
        echo "Record Deleted";
    } else {
        echo "Error deleting record: " . mysqli_error($link);
    }
    
    //// (Q11 Ends)
}




?>


<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            $(document.ready(function() {
                $("#testbtn").click(function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: 'p3.php',
                        type: 'POST',
                        data: {
                            'operation_val' : $("#operation_val").val(),
                        },
                        success: function(data, status) {
                            $("#test").html(data)
                        }
                    });
                });
                $("#insertbtn").click(function(e) {
                    echo "here0";
                    e.preventDefault();

                    $.ajax({
                        url: 'p3.php',
                        type: 'POST',
                        data: {
                            'operation_val' : $("#operation_val").val(),
                        },
                        success: function(data, status) {
                            echo "here";
                        }
                    });
                });
            }));
            
        </script>
        <link rel="stylesheet" href="p3.css">
    </head>

    <body>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="cars">Choose an operation:</label>
            <select name="operation" id="operation" onchange="this.form.submit()">
                <option value="0" <?php print ($operation_val == 0) ? "selected" : '' ;?>><b>Select Operation</b></option>
                <option value="1" <?php print ($operation_val == 1) ? "selected" : '' ;?>>Show</option>
                <option value="2" <?php print ($operation_val == 2) ? "selected" : '' ;?>>Update</option>
                <option value="3" <?php print ($operation_val == 3) ? "selected" : '' ;?>>Insert</option>
                <option value="4" <?php print ($operation_val == 4) ? "selected" : '' ;?>>Delete</option>
            </select></br></br>
            <?php


            $query = "SELECT * FROM fooditems__1_;";
            if($operation_val == 1){
                if($result = mysqli_query($link, $query)){
                    $fields_num = mysqli_num_fields($result);
                    echo "<table class=\"customTable\"><th>";
                    for($i=0; $i<$fields_num; $i++)
                    {
                        $field = mysqli_fetch_field($result);
                        if($i>0)
                        {
                            echo "<th>{$field->name}</th>";
                        }
                        else
                        {
                            echo "id";
                        }
                        
                    }
                    echo "</th>";
                    if($operation_val == 1){
                        while($row = mysqli_fetch_row($result)) {
                        ///// Finish the code for the table below using a loop (Q2)
                            echo "<tr>";
                            foreach($row as $cell) {
                                echo "<td>$cell</td>";
                            }
                            echo "</tr>";
                        ///////////// (Q2 Ends)
                        }
                        
                    }                    
                    echo "</table>";
            }
        }
            

            ?>

            


<div id="div_update" runat="server" class="<?php echo ($operation_val == 2) ? 'display-block' : 'display-none'; ?>">
    <!--Create an HTML table below to enter ID, amount, and calories in different text boxes. This table is used for updating records in your table. (Q3) --->
    <table>
        <tr>
            <td>ID:</td>
            <td><input type="text" name="update_id" id="update_id"></td>
        </tr> 
    </table>
    <!--(Q3) Ends --->
    
    <!--Create a button below to submit and update record. Set the name and id of the button to be "updatebtn"(Q4) --->
    <button type="submit" name="updatebtn" id="updatebtn">Update Record</button>
    <!--(Q4) Ends --->
</div>

<div id="div_insert" runat="server" class="<?php echo ($operation_val == 3) ? 'display-block' : 'display-none'; ?>">
    <!--Create an HTML table below to enter item, amount, unit, calories, protein, carbohydrate and fat in different text boxes. This table is used for inserting records in your table. (Q5) --->
    <table>
        <tr>
            <td>Item:</td>
            <td><input type="text" name="item" id="item"></td>
        </tr>
    </table>
    <!--(Q5) Ends --->
    
    <!--Create a button below to submit and insert record. Set the name and id of the button to be "insertbtn"(Q6) --->
    <button type="submit" name="insertbtn" id="insertbtn">Insert Record</button>
    <!--(Q6) Ends --->
</div>

<div id="div_delete" runat="server" class="<?php echo ($operation_val == 4) ? 'display-block' : 'display-none'; ?>">
    <!--Create an HTML table below to enter id a text box. This table is used for deleting records from your table. (Q7) --->
    <table>
        <tr>
            <td>ID to delete:</td>
            <td><input type="text" name="delete_id" id="delete_id"></td>
        </tr>
    </table>
    <!--(Q7) Ends--->
    
    <!--Create a button below to submit and delete record. Set the name and id of the button to be "deletebtn"(Q8) --->
    <button type="submit" name="deletebtn" id="deletebtn">Delete Record</button>
    <!--(Q8) Ends --->
</div>

            
        </form>

    </body>




</html>



