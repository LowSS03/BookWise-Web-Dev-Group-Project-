<?php
session_start();
include 'dbConn.php';

$cust_id = $_SESSION['custID'];

if(isset($_POST ['editBtn'])){
    $newCustName = $_POST['newcustName'];
    $newCustEmail = $_POST['newcustEmail'];
    $newCustNotel = $_POST['newcustNotel'];
    $newCustPassword = $_POST['newcustPassword'];
    $updateQuery = "UPDATE `customer` SET `customer_name` = '$newCustName', `customer_email` ='$newCustEmail', `customer_notel` ='$newCustNotel', `password` = '$newCustPassword' WHERE `customer_id` = '$cust_id'";
    if (mysqli_query($connection, $updateQuery)){
        echo '<script>alert("Details have been updated!")</script>';
        echo "<script>window.location = 'myAccount.php';</script>";
    }
    else{
        echo '<script>alert("Something went wrong, sorry...")</script>';
    }
}

    $query = "SELECT * FROM `customer` WHERE `customer_id`= '$cust_id'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $count = mysqli_num_rows($result);
    if ($count ==1){
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
        body{
            margin: 0;
            width: 100%;
            height: 100%;
            background-color: pink;
            background-image: url("image/iceedge.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }

        .menubar {
            width: 100%;
            top: 0;
            position: relative;
            left: 0;
            z-index: 9999;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .2);
        }

        .all{
            margin-top: 5%;
            background-color: blue;
            width: 100%;
            height: 90%;
        }
        
        #custBox {
            position: absolute;
            background-image: url("image/lakeside.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            width: 400px;
            margin-left: 35%;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            animation: swipeUp 2s forwards;
        }

        @keyframes swipeUp{
            0%{
                opacity: 0;
                margin-top: 100%;
            }
            100%{
                opacity: 1;
            }
        }
        
        #custBox h2 {
            margin-top: 0;
            text-align: center;
        }
        
        #custBox table {
            width: 100%;
        }
        
        #custBox td {
            padding: 10px 0;
            color: white;
        }
        
        input[type="text"],
        button {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        #custBox td button {
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }
        
        #custBox button:hover {
            background-color: #45a049;
        }
        
        #custBox li {
            margin-top: 10px;
        }
        
        #custBox li a {
            color: #007bff;
            text-decoration: none;
        }
        
        #custBox li a:hover {
            text-decoration: underline;
        }
    </style>
<body>
<div class="menubar">
    <?php include 'menubar.php';?>
</div>
<div class="all">
    <div id=custBox>
        <h2>My Account</h2>
        <form action="myAccount.php" method="POST">
            <table>
                <tr>
                    <td>Customer Name</td>
                    <td>:</td>
                    <td><input type="text" name="newcustName" value="<?php echo $row['customer_name'];?>"></td>
                </tr>
                </tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><input type="text" name="newcustEmail" value="<?php echo $row['customer_email'];?>"></td>
                </tr>
                </tr>
                    <td>Password</td>
                    <td>:</td>
                    <td><input type="text" name="newcustPassword" value="<?php echo $row['password'];?>"></td>
                </tr>
                </tr>
                    <td>Phone Number</td>
                    <td>:</td>
                    <td><input type="text" name="newcustNotel" value="<?php echo $row['customer_notel'];?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><button type="submit" name="editBtn">Save Changes</button></td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>