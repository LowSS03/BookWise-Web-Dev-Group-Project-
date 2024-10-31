<?php
session_start();
include 'dbConn.php';
$query = "SELECT * FROM hotel";

// Function to sanitize user input
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the city search value is set
if (isset($_POST['cityselect']) && !empty($_POST['cityselect'])) {
    $cityTerm = sanitize($_POST['cityselect']);
    $query .= " WHERE state = '$cityTerm'";
}

// Check if the hotel name search value is set
if (isset($_POST['nametf']) && !empty($_POST['nametf'])) {
    $hotelTerm = sanitize($_POST['nametf']);
    if (isset($_POST['cityselect']) && !empty($_POST['cityselect'])) {
        $query .= " AND";
    } else {
        $query .= " WHERE";
    }
    $query .= " hotel_name LIKE '%$hotelTerm%'";
}

$query .= " ORDER BY hotel_id ASC";
$result = mysqli_query($connection, $query);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pricefilter'])) {
    $pricetype = $_POST['pricefilter'];

    // Modify the query based on the selected price range
    switch ($pricetype) {
        case "1":
            $query = "SELECT * FROM hotel WHERE rating <= 1";
            break;
        case "2":
            $query = "SELECT * FROM hotel WHERE rating <= 2";
            break;
        case "3":
            $query = "SELECT * FROM hotel WHERE rating <= 3";
            break;
        case "4":
            $query = "SELECT * FROM hotel WHERE rating <= 4";
            break;
        case "5":
            $query = "SELECT * FROM hotel WHERE rating <= 5";
            break;
        default:
            $query = "SELECT * FROM hotel";
            break;
    }

    $result = mysqli_query($connection, $query);
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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

        #citylabel1{
            margin-right: 20px;
            width: 200px;
            height: 30px;
            background-color: transparent;
            border: none;
            border-bottom: 1px solid #ccc;
            transition: all 0.5s ease-in-out;
            color: rgb(200, 200, 200);
            cursor: pointer;
        }

        #citylabel1:hover{
            width: 250px;
            background-color: rgb(0, 0, 0, 0.5);
        }

        #citylabel1:focus{
            width: 250px;
            background-color: rgb(0, 0, 0, 0.5);
            outline: none;
        }

        #citylabel1 Option{
            color: white;
            cursor: pointer;
        }

        #hotelcontent{
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

        #hotelcontent:hover{
            background-color: rgb(240, 240, 240);;
        }

        .image-container {
            float: left;
            width: 23%;
            margin-bottom: -2px;
            margin-left: 2px;
            margin-top: 2px;
        }

        .hotel-information{
            margin-left: 35%;
            width: 500px;
            font-family: arial;
        }

        .hotel-information h3{
            font-size: 25px;
            width: 500px;
        }

        .hotel-information p{
            font-size: 15px;
        }

        #contentright{
            float:right;
            margin-top: -7%;
        }

        #button{
            margin-right: 20px;
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

        .button{
            margin-top: 10%;
        }

        .submit{
            color: white;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .submit input{
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
            font-size: 25px;
            width: 35px;
        }

        .fa-envelope, .fa-phone{
            color: black;
            width: 25px;
        }

        
        .star-rating {
            font-size: 16px;
        }

        .star-rating span {
            color: gold;
        }
    </style>
</head>
<body>
<div class="menubar">
    <?php include "menubar.php"; ?>
</div>

<div id="datepicker">   
    <form action="#" method="post">
        <div class="city">
            <label for="city" id ="citylabel">City:</label>
                <select name="cityselect" id="citylabel1">
                    <option value="">Please Select The City:</option>
                    <option value="Penang">Penang</option>
                    <option value="Perak">Perak</option>
                    <option value="Selangor">Selangor</option>
                    <option value="Kuala Lumpur">Kuala Lumpur</option>
                    <option value="Johor">Johor</option>
                    <option value="Malacca">Malacca</option>
                    <option value="Kedah">Kedah</option>
                    <option value="Negeri">Negeri Sembilan</option>
                </select>
            </div>
            <div class="search">
                <label for="hotelnamelabel">Hotel Name: </label>
                <input id ="hotelf" type="text" name="nametf" placeholder="Search">
                🔍 <input id ="search" type="submit" value="Search">
            </div>
        </form>
    </div>

    <?php 
        if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <div id="hotelcontent">
        <div class="image-container">
            <img class="room-image" src="data:image;base64,<?php echo base64_encode($row['hotel_image']); ?>" alt="Hotel Image" height="165px" width="280px">
        </div>
        <div class="hotel-information">
            <h3 name = "hotelname">🏨<?php echo $row['hotel_name']; ?></h3>
            <p>📩<?php echo $row['hotel_email']; ?></p>
            <p>☎️</i><?php echo $row['hotel_notel']; ?></p>
        </div>
    
        <div id="contentright">
            <span><a id="button" href="room.php?hotelID=<?php echo $row['hotel_id']; ?>" class=”button”> Check Availability </a></span><br><br>
            <span class="star-rating"> Ratings : <br>
            <?php
            $rating = $row['rating'];
            for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                echo '<span class="fa fa-star"></span>';
            } else {
                echo '<span class="fa fa-star-o"></span>';
            }
            }
    ?>
  </span> 
        </div>
    </div>

    <?php 
        }
    } else {
        echo '<tr><td style="padding:8pxpx; text-transform:capitalize; text-align:center;" colspan="20"; ><h2>No Room between the range selected.</h2></td></tr>';
    }
    mysqli_close($connection);
 ?>

    <div class="filter">
        <h2><b>Filter By:</b></h2>
        <div class="price">
            <h3><b>Rating:</b></h3>
            <form action="" method = "post">
            <select name="pricefilter">
                <option value="">-----</option>
                <option value="1">⭐</option>
                <option value="2">⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="5">⭐⭐⭐⭐⭐</option>
            </select>
            <br>
                <div class="button">
                    <button class="submit"><input type="submit" name="submit" value="Submit"></button>
                    <button class="clear" type ="button" onclick="back()">Clear</button>
                    <script>
                        function back(){
                            location.replace('viewhotel.php')
                        
                        }
                    </script>
                </div>
            </form>
        </div>
    </div>
       
</body>
</html>