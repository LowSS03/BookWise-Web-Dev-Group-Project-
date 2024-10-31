<?php
session_start();
include 'dbConn.php';

// Check if check-in and check-out dates are submitted
if (isset($_POST['checkin']) && isset($_POST['checkout'])) {
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    // Validate the selected dates
    if (strtotime($checkout) < strtotime($checkin)) {
        $error = "Invalid date range. Please select a valid range.";
    } else {
        if (isset($_POST['roomType'])) {
            $roomType = $_POST['roomType'];
            if ($roomType !== "All") {
                $query = "SELECT * FROM room 
                INNER JOIN hotel ON room.hotel_id = hotel.hotel_id
                WHERE room_type = '$roomType'";
            } else {
                $query = "SELECT * FROM hotel 
                INNER JOIN room ON room.hotel_id = hotel.hotel_id";
            }
        } else {
            $roomType = "All"; // Set default value to "All"
            $query = "SELECT * FROM hotel 
            INNER JOIN room ON room.hotel_id = hotel.hotel_id";
        }
    }
} else {
    $checkin = "";
    $checkout = "";
    $roomType = "All"; // Set default value to "All"
    $query = "SELECT * FROM hotel 
    INNER JOIN room ON room.hotel_id = hotel.hotel_id";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pricefilter'])) {
    $pricetype = $_POST['pricefilter'];

    // Modify the query based on the selected price range
    switch ($pricetype) {
        case "Below RM100":
            $query .= " WHERE room_price < 100";
            break;
        case "Below RM200":
            $query .= " WHERE room_price < 200";
            break;
        case "Below RM300":
            $query .= " WHERE room_price < 300";
            break;
        case "Above RM300":
            $query .= " WHERE room_price > 300";
            break;
    }

    $result = mysqli_query($connection, $query);
}

$result = mysqli_query($connection, $query);

// Function to check date availability
function checkDateAvailability($connection, $roomID, $checkin, $checkout)
{
    $query = "SELECT * FROM booking
              WHERE room_id = '$roomID' AND
                    (checkin_date BETWEEN '$checkin' AND '$checkout' OR
                    checkout_date BETWEEN '$checkin' AND '$checkout')";
    $result = mysqli_query($connection, $query);
    $numRows = mysqli_num_rows($result);
    return $numRows == 0; // Return true if the dates are available, false otherwise
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>

        body{
            margin: 0;
            background-color: lightblue;
        }

        .menubar{
            width: 100%;
            top: 0;
            position: relative;
            left: 0;
            z-index: 9999;
            box-shadow: 0 2px 4px 0 rgba(0,0,0,.2);
        }

        #datepicker{
            padding: 10px 0px;
            height: 70px;
            background-color: rgb(9, 80, 102);
            width: 100%;
        }

        .roomtype{
            margin-top: 1.5%;
            margin-left: 25%;
            color: white;
        }

        .city{
            margin-left: 20%;
            margin-top: 15px;
            color: white;
        }

        .search{
            margin-left: 60%;
            margin-top: -25px;
            color: white;
        }

        .roomlabel1{
            margin-right: 20px;
            width: 150px;
            height: 30px;
            background-color: transparent;
            border: none;
            border-bottom: 1px solid #ccc;
            transition: all 0.5s ease-in-out;
            color: rgb(200, 200, 200);
            cursor: pointer;
        }

        .roomlabel1:hover{
            width: 200px;
            background-color: rgb(0, 0, 0, 0.5);
        }

        .roomlabel1:focus{
            width: 200px;
            background-color: rgb(0, 0, 0, 0.5);
            outline: none;
        }

        #citylabel1 Option{
            color: white;
            cursor: pointer;
        }

        #roomcontent{
            margin-top: 20px;
            height: 30%;
            width: 60%;
            float: right;
            margin-right: 15%;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            box-shadow: 8px 8px 8px 0 rgba(0,0,0,.2);
            background-color: white;
            transition: 0.2s ease-in-out;
        }

        #roomcontent:hover{
            background-color: rgb(240, 240, 240);;
        }

        .image-container {
            float: left;
            width: 23%;
            margin-bottom: -2px;
            margin-left: 2px;
            margin-top: 2px;
        }

        .room-information{
            margin-left: 35%;
            width: 500px;
            font-family: arial;
        }

        .room-information h3{
            font-size: 25px;
            width: 500px;
        }

        .room-information p{
            font-size: 15px;
        }

        #contentright{
            float:right;
            margin-top: -5%;
        }

        #button{
            margin-right: 20px;
            /* margin-top: 200px; */
            background-color: rgba(76, 68, 239, 0.8);
            padding: 5px 10px 5px 10px;
            text-align:center;
            border-radius: 2.5px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            transition: 0.5s ease-in-out;
        }

        #button:hover{
            cursor: pointer;
            background-color: rgb(119, 0, 137);
        }

        #search{
            color: white;
            background-color: transparent;
            border: none;
            transition: 0.3s ease-in-out;
        }

        #search input{
            border: none;
            color: white;
            background-color: transparent;
            transition: 0.3s ease-in-out;
            cursor: pointer;
        }

        #search input:hover, #search:hover{
            background-color: green;
        }

        #hotelf{
            margin-right: 20px;
            width: 150px;
            height: 30px;
            background-color: transparent;
            border: none;
            border-bottom: 1px solid #ccc;
            transition: all 0.5s ease-in-out;
            color: white;
            cursor: pointer;
        }

        #hotelf:hover{
            width: 200px;
            background-color: rgb(0, 0, 0, 0.5);
        }

        #hotelf:focus{
            width: 200px;
            background-color: rgb(0, 0, 0, 0.5);
            outline: none;
        }

        #hotelf::placeholder{
            color: rgb(200, 200, 200);
        }

        .filter{
            margin-top: 0%;
            background-image: url("image/plane.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100%;
            width: 15%;
            height: 600px;
            padding: 10px 40px;
        }

        .filter h2{
            font-size: 40px;
            color: white;
        }

        .price{
            color: white;
        }

        .price select{
            margin-right: 20px;
            width: 120px;
            height: 20px;
            background-color: transparent;
            border: none;
            border-bottom: 1px solid #ccc;
            transition: all 0.5s ease-in-out;
            color: white;
            cursor: pointer;
        }

        .price select:hover{
            width: 150px;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .price select:focus{
            width: 150px;
            background-color: rgba(0, 0, 0, 0.5);
            outline: none;
        }

        .price option{
            color: white;
        }

        /* .button{
            margin-top: 15%;
        } */

        .datesubmit{
            color: white;
            font-weight: bold;
            background-color: transparent;
            border: none;
            cursor: pointer;
            transition: 0.3s ease-in;
        }

        .datesubmit:hover{
            background-color: green;
        }

        .submit input, .submit{
            font-size: 15px;
            color: white;
            font-weight: bold;
            background-color: transparent;
            border: none;
            cursor: pointer;
            transition: 0.3s ease-in;
        }

        .submit input:hover{
            background-color: green;
        }

        .clear{
            font-size: 15px;
            color: white;
            background-color: transparent;
            font-weight: bold;
            border: none;
            transition: 0.3s ease-in;
            cursor: pointer;
        }

        .clear:hover{
            background-color: red;
        }

        .fa-institution{
            color: black;
            width: 35px;
        }

        .fa-hotel, .fa-align-justify, .fa-money{
            color: black;
            width: 25px;
        }

    </style>
</head>
<body>
<div class="menubar">
    <?php include "menubar.php"; ?>
</div>
<div id="datepicker">
    <div class="roomtype">
        <form action="#" method="POST" id="roomForm">
            Sort Room Type:
            <select class="roomlabel1" name="roomType" onchange="this.form.submit()">
                <option value="All" <?php if ($roomType == 'All') { echo 'selected'; } ?>>All</option>
                <option value="Single Room" <?php if ($roomType == 'Single Room') { echo 'selected'; } ?>>Single Room</option>
                <option value="Double Room" <?php if ($roomType == 'Double Room') { echo 'selected'; } ?>>Double Room</option>
                <option value="Triple Room" <?php if ($roomType == 'Triple Room') { echo 'selected'; } ?>>Triple Room</option>
                <option value="President Room" <?php if ($roomType == 'President Room') { echo 'selected'; } ?>>President Room</option>
            </select>

            <label for="checkin">Check-in Date:</label>
            <input type="date" id="checkin" name="checkin" value="<?php echo $checkin; ?>" required>

            <label for="checkout">Check-out Date:</label>
            <input type="date" id="checkout" name="checkout" value="<?php echo $checkout; ?>" required>

            <input class="datesubmit" type="submit" value="Submit">
            <input class="datesubmit" type="button" onclick="resetForm()" value="Reset">

            <script>
                function resetForm() {
                    location.replace('roomListCard.php')
                }
            </script>

        </form>
    </div>
</div>






    <?php 
        while($row = mysqli_fetch_assoc($result)){
    ?>

<div id="roomcontent">
        <div class="image-container">
            <img class="room-image" src="data:image;base64,<?php echo base64_encode($row['room_image']); ?>" height="225px" width="280px">
        </div>

        <div class="room-information">
            <h3 name = "hotelname">🏨<?php echo $row['hotel_name']; ?></h3>
            <p>🛏️<?php echo $row['room_type']; ?></p>
            <p>💬<?php echo $row['room_description']; ?></p>
            <p>💵<?php echo $row['room_price']; ?></p>
        </div>
    
        <div id="contentright">
            <?php
                $roomID = $row['room_id'];
                
                if (($checkin !== "" && $checkout !== "") && checkDateAvailability($connection, $roomID, $checkin, $checkout)) {
                    echo '<a id="button" href="customerBook.php?roomID=' . $row['room_id']. '" class=”button”>🎟️ Book </a>';
                } elseif ($checkin === "" && $checkout === "") {
                    echo '<a id="button" href="customerBook.php?roomID=' . $row['room_id']. '" class=”button”>🎟️ Book </a>';
                } else {
                    echo '<span class="booked-message">Room Not Available</span>';
                }
                ?>
        </div>
    </div>

            <?php
        }
        mysqli_close($connection);
        ?>

    <div class="filter">
        <h2><b>Filter By:</b></h2>
        <div class="price">
            <h3><b>Price:</b></h3>
            <form action="" method = "post">
                <select name="pricefilter">
                    <option value="">-----</option>
                    <option value="Below RM100">Below RM100</option>
                    <option value="Below RM200">Below RM200</option>
                    <option value="Below RM300">Below RM300</option>
                    <option value="Above RM300">Above RM300</option>
                </select>
            <br>
                <div class="button">
                    <button class="submit"><input type="submit" name="submit" value="Submit"></button>
                    <button class="clear" type ="button" onclick="back()">Clear</button>
                    <script>
                        function back(){
                            location.replace('roomListCard.php')
                        
                        }
                    </script>
                </div>
            </form>
        </div>
    </div>
</body>
</html>