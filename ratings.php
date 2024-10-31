<?php
session_start();
include 'dbConn.php';

$hotelquery= "SELECT hotel_name FROM hotel ";
$result = mysqli_query($connection, $hotelquery);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $hotelName = $_POST['choose_hotel'];
    $rating = $_POST['rating'];

    $query = "SELECT * FROM hotel WHERE hotel_name = '$hotelName'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $currentRating = $row['rating'];
    $numRating = $row['num_rating'];
    $avrRating = ($currentRating * $numRating + $rating)/($numRating + 1 );

    $updateQuery = "UPDATE hotel SET rating = $avrRating, num_rating = $numRating + 1 WHERE hotel_name = '$hotelName'";
    mysqli_query($connection, $updateQuery);

    echo '<script>alert("Rating submitted successfully! Thank you!")</script>';
    echo "<script>window.location='homepage.php'</script>";
};




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
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
            background-image: url("image/hotel1.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            overflow: hidden;
            z-index: -1;
        }

        #custBox {
            background-image: url("image/hotel.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: white;
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

        h2 {
            text-align: center;
            margin-top: 30px;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
        }
        
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        
        .rate_btn {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        
        .rate_btn:hover {
            background-color: #45a049;
        }
    </style>
<body>
    <div class="menubar">
        <?php include 'menubar.php';?>
    </div>
    
    <div id=custBox>
    <h2>Please rate a hotel </h2>
    <form action="" method="post">
        <label for="choose_hotel">Hotel Name:</label><br>
        <select id="choose_hotel" name="choose_hotel">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['hotel_name'] . '">' . $row['hotel_name'] . '</option>';
                    if (!empty($row['hotel_image'])) {
                        echo '<img id="imagePreview" src="data:image;base64,' . base64_encode($row['hotel_image']) . '" height="200" width="100%">';
                    } else {
                        echo 'No image available';
                    }
                }
            } else {
                echo '<option value="">No hotels found</option>';
            }
            ?>
        </select><br><br>
        <label for="rating">Rating:</label>
        <select id="rating" name="rating">
            <option value="1">⭐</option>
            <option value="2">⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="5">⭐⭐⭐⭐⭐</option>
        </select><br><br>
        <input class="rate_btn" type="submit" name="submit" value="👌🏻Submit"><br><br><br>
    </form>
        </div>
</body>
</html>