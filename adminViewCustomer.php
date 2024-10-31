<?php
session_start();
include 'dbConn.php';
$query = "SELECT * FROM customer";

if (isset($_POST['saveBtn'])) {
    $custID = $_POST['custID'];
    $newCustName = $_POST['newcustName'];
    $newCustEmail = $_POST['newcustEmail'];
    $newCustNotel = $_POST['newcustNotel'];
    $newCustPassword = $_POST['newcustPassword'];
    $updateQuery = "UPDATE `customer` SET `customer_name` = '$newCustName', `customer_email` ='$newCustEmail', `customer_notel` ='$newCustNotel', `password` = '$newCustPassword' WHERE `customer_id` = '$custID'";
    if (mysqli_query($connection, $updateQuery)) {
        echo "<script>";
        echo "alert('Customer Updated Successfully');";
        echo "window.location = 'adminViewCustomer.php';";
        echo "</script>";
    } else {
        echo '<script>alert("Something went wrong, sorry...")</script>';
    }
}

// Function to sanitize user input
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


// Check if the hotel name search value is set
if (isset($_POST['nametf']) && !empty($_POST['nametf'])) {
    $searchTerm = sanitize($_POST['nametf']);
    $query .= " WHERE customer.customer_name LIKE '%$searchTerm%'";
}


// Add sorting functionality
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'customer_id';
$sortOrder = isset($_GET['order']) ? $_GET['order'] : 'ASC';

$query .= " ORDER BY $sortColumn $sortOrder";

$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Styles */

        .menubar {
            width: 100%;
            top: 0;
            position: relative;
            left: 0;
            z-index: 9999;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .2);
        }

        body {
            margin: 0;
            background: linear-gradient(45deg, #49a09d, #5f2c82);
        }

        .all-table{
            font-family: sans-serif;
            font-weight: 100;
            position: relative;
            margin-top: 10px;
            left: 0;
        }

        .custTable {
            font-family: sans-serif;
            font-weight: 100;
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .custTable th,
        .custTable td {
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.2);
            text-align: center;
            color: white;
        }

        .custTable tbody:hover td {
            color: transparent;
            text-shadow: 0 0 3px #aaa;
        }

        .custTable tbody:hover tr:hover td {
            text-shadow: 0 1px 0 white;
        }

        .custTable th {
            background-color: #55608f;
        }

        .custTable tr:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .custTable tr.title2 {
            pointer-events: none;
        }

        form {
            display: flex;
            justify-content: center;
            padding: 10px;
            color: white;
        }

        .book-link {
            color: #007bff;
            text-decoration: none;
        }

        .book-link:hover {
            text-decoration: underline;
        }

        .booked-message {
            color: #dc3545;
        }

        .icon {
            margin-right: 5px;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .button {
            background-color: #3EB489;
            padding: 5px 10px;
            border-radius: 2.5px;
            color: white;
            text-decoration: none;
            border: none;
        }

        .button:hover {
            background-color: rgba(0, 128, 128, 0.8);
        }

        .input {
            background-color: transparent;
            border: none;
            font-size: 15px;
        }

        .input:focus{
            outline: none;
        }

        .inputCust{
            background-color: transparent;
            border: none;
            font-size: 15px;
            color: white;
            text-align: center;
            transition: 0.2s ease-in;
        }

        .inputCust:hover{
            background-color: rgb(0, 0, 0, 0.6);
        }

        .inputCust:hover{
            outline: none;
            border: none;
            background=color: rgb(0, 0, 0, 0.6);
        }

        input[type=file]::file-selector-button {
            background: transparent;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            text-decoration: underline;
        }

        input[type=file]::file-selector-button:hover {
            background: green;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .searchname{
            margin-left: 2%;
            position: relative;
            display: flex;
            flex-direction: row;
            width: 20%;
            max-width: 400px;
            border-radius: 2px;
            padding: 5px 10px 5px;
            transition: all 0.5s ease-in-out;
            &:after {
                content: "";
                position: absolute;
                left: 0px;
                right: 0px;
                bottom: 0px;
                z-index: 999;
                height: 2px;
                border-bottom-left-radius: 2px;
                border-bottom-right-radius: 2px;
                background-position: 0% 0%;
                background: linear-gradient(to right, #B294FF, #57E6E6, #FEFFB8, #57E6E6, #B294FF, #57E6E6);
                background-size: 500% auto;
                animation: gradient 3s linear infinite;
            }
        }

        .searchname:hover{
            background: rgba(57, 63, 84, 0.8);
            width: 30%;
            transition: all 0.5s ease-in-out;
        }

        .searchname:focus{
            background: rgba(57, 63, 84, 0.8);
            padding-left:80px;  
            margin-left:35px;
            outline: none;
            transition: all 0.5s ease-in-out;
        }

        .searchname input{
            flex-grow: 1;
            color: #BFD2FF;
            font-size: 15px;
            line-height: 20px;
            vertical-align: middle;
            &::-webkit-input-placeholder {
                color: #FEFFB8;
            }
        }
    </style>
</head>
<body>
    <div class="menubar">
        <?php include "menubar.php"; ?>
    </div>
    <div class="all-table">
    <form action="#" method="POST">
        <div class="searchname">
            <input class="input" type="text" name="nametf" placeholder="Search Name">
        </div>
    </form>

        <table class="custTable">
            <tr class="title2">
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Customer Password</th>
                <th>Customer Phone Number</th>
                <th align="center">Option</th>
            </tr>

            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>

            <tr>
                <form action="#" method="POST">
                    <td>
                        <?php echo $row['customer_id']; ?>
                        <input class="inputCust" type="hidden" name="custID" value="<?php echo $row['customer_id']; ?>">
                    </td>
                    <td><input class="inputCust" type="text" name="newcustName" value="<?php echo $row['customer_name']; ?>"></td>
                    <td><input class="inputCust" type="text" name="newcustEmail" value="<?php echo $row['customer_email']; ?>"></td>
                    <td><input class="inputCust" type="text" name="newcustPassword" value="<?php echo $row['password']; ?>"></td>
                    <td><input class="inputCust" type="text" name="newcustNotel" value="<?php echo $row['customer_notel']; ?>"></td>

                    <td align="center">
                        <div class="button-container">
                            <a href=""><button class="button" type="submit" name="saveBtn">Save 📝</button></a>
                            <a href="adminDeleteCustomer.php?customerID=<?php echo $row['customer_id']; ?>" class="button">Delete 🗑️</a>
                        </div>
                    </td>
                </form>
            </tr>

            <?php
                }
            } else {
                echo '<tr><td style="padding:8pxpx; text-transform:capitalize; text-align:center;" colspan="20"; ><h2>No Bookings have been made.</h2></td></tr>';
            }
            mysqli_close($connection);
            ?>


        </table>
</div>
</body>

</html>
</body>

</html>