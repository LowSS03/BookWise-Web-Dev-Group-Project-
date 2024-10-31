<?php
session_start();
include 'dbConn.php';
$hotelID = $_GET['hotelID'];

// Query to fetch hotel information
$hotelQuery = "SELECT * FROM hotel WHERE hotel_id = '$hotelID'";
$hotelResult = mysqli_query($connection, $hotelQuery);
$hotelRow = mysqli_fetch_assoc($hotelResult);

// Query to fetch room information
$query = "SELECT * FROM room 
          INNER JOIN hotel ON hotel.hotel_id=room.hotel_id
          WHERE room.hotel_id = '$hotelID'";
$result = mysqli_query($connection, $query);
$totalRooms = mysqli_num_rows($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        #content{
            padding-top: 5%;
            background-color: rgb(75, 0, 90);
            height: 310px;
            
        }

        .hotel-image{
            border-radius: 5%;
            float:left;
            animation: flowIn 2s forwards;
        }

        @keyframes flowIn{
            0%{
                opacity: 0;
                margin-left: -100%;
            }
            100%{
                opacity: 1;
            }
        }

        #imageform{
            padding-top: 30px;
            padding-left: 10%;
            padding-bottom: 30px;
            padding-right: 50px;
            float: left;
        }

        #hotelinfo{
            padding-top: 100px;
            margin-left: 30px;
        }

        #hotelname{
            color: white;
        }

        #hotelname h1{
            font-size: 40px;
        }

        #contentright{
            padding-left: 5%;
            margin-top: -11%;
            margin-right: 10%;
            float: right;
            border-left: 2px solid rgba(169, 154, 175, 0.85);
            height: 150px;
        }

        #select{
            font-size: 35px;
            margin-left: 10%;
            margin-top: 2%;
            color: black;
        }
        
        #noroom{
            font-size: 25px;
            margin-left: 10%;
            color: rgba(84, 56, 95, 0.83);
        }

        #showroom{
            margin-top: 30px;
            height: 45%;
            width: 70%;
            margin-left: 18%;
            margin-right: 15%;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            box-shadow: 8px 8px 8px 0 rgba(0,0,0,.2);
            background-color: white;
            color: black;
            transition: 0.2s ease-in-out;
        }

        #showroom:hover{
            background-color: rgb(230, 230, 230);
        }

        .room-image img{
            margin-top: 2%;
            margin-left: 1%;
        }

        #roomdetails{
            float: right;
            padding-right: 30px;
            margin-top: -15%;
            color: black;
        }

        #button{
            margin-right: 20px;
            background-color: rgba(119, 149, 12, 0.83);
            padding: 5px 10px 5px 10px;
            text-align:center;
            border-radius: 2.5px;
            cursor: pointer;
            transition: 0.4s ease-in-out;
        }

        #button:hover{
            background-color: lightgreen;
        }

        a{
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        #roomdes{
            padding: 25px 25px 30px 25px;
            margin-left: 25%;
            margin-top: -17.8%;
        }

        #roomdes p{
            color: black;
        }

        .description{
            width: 70%;
            height: 40px;
            overflow: auto;
        }

        .description:hover{
            background-color: rgb(0, 0, 0, 0.2);
        }

        #roomdetails p{
            color: black;
        }

        .fa-institution{
            color: white;
            font-size: 25px;
            width: 55px;
        }

        .fa-envelope, .fa-phone{
            color: white;
            width: 25px;
        }

    </style>
</head>
<body>
<div class="menubar">
    <?php include "menubar.php"; ?>
</div>
    <div id="content">
        <div id="imageform">
            <img class="hotel-image" src="data:image;base64,<?php echo base64_encode($hotelRow['hotel_image']); ?>" alt="Hotel Image" height="250px" width="350px">
        </div>
        <div id="hotelinfo">
            <div id="hotelname">
                <h1><b>🏩<?php echo $hotelRow['hotel_name']; ?></b></h1>
                <h3>✉️<?php echo $hotelRow['hotel_email']; ?></h3>
                <h3>☎️<?php echo $hotelRow['hotel_notel']; ?></h3>
            </div>
        </div>
        <div id="contentright">
            <p></p>
            <p><?php echo $hotelRow['address']; ?></p>
            <p><?php echo $hotelRow['postcode']; ?></p>
            <p><?php echo $hotelRow['state']; ?></p>
        </div>
    </div>

    <div id="select"><b>Select your Room</b></div>
    
    <p id="noroom"><?php echo $totalRooms; ?> room(s) found</p>

    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        ?>

        <div id="showroom">
            <div class="room-image">
                <img src="data:image;base64,<?php echo base64_encode($row['room_image']); ?>" alt="Room Image" height="170px" width="270px">
            </div>
            <div id="roomdes">
                <p>🆔<?php echo $row['room_id']; ?></p>
                <p>🛏️<?php echo $row['room_type']; ?></p>
                <p class="description">💬<?php echo $row['room_description']; ?></p>
            </div>

            <div id="roomdetails">
                <p><?php echo $row['room_price']; ?></p>
                <p>MYR Per Night</p>
                <div id="button">
                    <a href="customerBook.php?roomID=<?php echo $row['room_id'];?>" class="button">🎫 Book Room</a>
                </div>
            </div>
        </div>

    <?php
    }
    ?>
</body>
</html>