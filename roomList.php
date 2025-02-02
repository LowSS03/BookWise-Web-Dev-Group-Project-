<?php
session_start();
include 'dbConn.php';
if (isset($_POST['roomType'])){
    $roomType = $_POST['roomType'];
    if($roomType !== "All"){
        $query = "SELECT * FROM room WHERE hotel_id = {$_SESSION['hotelID']} AND room_type = '$roomType'";
    } else{
        $query = "SELECT * FROM room WHERE hotel_id=". $_SESSION["hotelID"];
    }
} else {
    $roomType = "All"; // Set default value to "All"
    $query = "SELECT * FROM room WHERE hotel_id=". $_SESSION["hotelID"];
}
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

        .menubar{
            width: 100%;
            top: 0;
            position: relative;
            left: 0;
            z-index: 9999;
            box-shadow: 0 2px 4px 0 rgba(0,0,0,.2);
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

        .designTable {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .designTable th, .designTable td {
            padding: 15px;
            background-color: rgba(255,255,255,0.2);
            text-align: center;
            color: white;
        }

        .designTable tbody:hover td {
            color: transparent;
            text-shadow: 0 0 3px #aaa;
        }

        .designTable tbody:hover tr:hover td {
            text-shadow: 0 1px 0 white;
        }

        .designTable th {
            background-color: #55608f;
        }

        .designTable tr:hover {
            background-color: rgba(255,255,255,0.3);
        }
        
        .designTable tr.title2 {
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
        }
        
        .button:hover {
            background-color: rgba(0, 128, 128, 0.8); 
        }

        .custom-select{
            border: 0;
            background: none;
            display: block;
            margin: 20px auto;
            text-align: center;
            border: 2px solid #3498db;
            height: 40px;
            width: 230px;
            outline: none;
            color: white;
            border-radius: 24px;
            transition: 0.25s;
        }

        .custom-select:hover{
            box-shadow: 0 0 4px rgb(204, 204, 204);
            border-radius: 2px 2px 0 0;
            background-color: transparent;
        }

        .custom-select:focus{
            width: 280px;
            border-color: #2ecc71;
        }

        .custom-select.has-value,
        .custom-select:focus:not(:placeholder-shown) {
            color: white;
            background-color: rgb(0, 0, 0, 0.5);
        }

    </style>
</head>
<body>
    <div>
        <div class="menubar">
            <?php include "menubar.php"; ?>
        </div>
    </div>
    <div class="all-table">
    <form action="#" method="POST">
        <!-- Sort Room Type:  -->
            <select class="custom-select" name="roomType" onchange="this.form.submit()">
                <option value="All" <?php if($roomType == 'All') { echo 'selected'; } ?>>All</option>
                <option class="option" value="Single Room" <?php if($roomType == 'Single Room') { echo 'selected'; } ?>>Single Room</option>
                <option class="option" value="Double Room" <?php if($roomType == 'Double Room') { echo 'selected'; } ?>>Double Room</option>
                <option class="option" value="Triple Room" <?php if($roomType == 'Triple Room') { echo 'selected'; } ?>>Triple Room</option>
                <option class="option" value="President Room" <?php if($roomType == 'President Room') { echo 'selected'; } ?>>President Room</option>
            </select>
    </form>
            
    <table class="designTable">
        <tr class="title2">
            <th>Room ID</th>
            <th>Room Image</th>
            <th>Room Description</th>
            <th>Room Type</th>
            <th>Room Price (RM)</th>
            <!-- <th>Room Status</th> -->
            <th align="center">Option</th>
        </tr>

        <?php
        while ($row = mysqli_fetch_assoc($result)){
        ?>

        <tr>
            <td><?php echo $row['room_id']; ?></td>
            <td><?php echo '<img src="data:image;base64,' . base64_encode($row['room_image']) . '" height="175" width="175">';?></td>
            <td><?php echo $row['room_description']; ?></td>
            <td><?php echo $row['room_type']; ?></td>
            <td><?php echo $row['room_price']; ?></td>
            <!-- <td><?php echo $row['room_status']; ?></td> -->
            <td>
                <div class="button-container">
                    <a href="hotelBook.php?roomID=<?php echo $row['room_id']; ?>" class="button">Book 🎫</a>
                    <a href="editRoom.php?roomID=<?php echo $row['room_id']; ?>" class="button">Edit 📝</a>
                    <a href="deleteRoom.php?roomID=<?php echo $row['room_id']; ?>" class="button">Delete 🗑️</a>
                </div>
            </td>
        </tr>

        <?php
        }
        mysqli_close($connection);
        ?>

    </table>
    </div>
</body>
</html>