<?php
session_start();
include 'dbConn.php';

if (isset($_POST['btnAdd'])) {
    $hotel = $_POST['hotelID'];
    $roomDescription = $_POST['RoomDescription'];
    $roomType = $_POST['RoomType'];
    $price = $_POST['RoomPrice'];
    $status = $_POST['RoomStatus'];

    // Check if required fields are empty
    if (empty($hotel) || empty($roomDescription) || empty($roomType) || empty($price) || empty($status)) {
        echo '<script>alert("Please fill in all required fields.")</script>';
    } elseif ($price <= 0) {
        echo '<script>alert("Price must be greater than zero.")</script>';
    } elseif (empty($_FILES['RoomImage']['tmp_name'])) {
        echo '<script>alert("Please upload an image.")</script>';
    } else {
        $image = addslashes(file_get_contents($_FILES['RoomImage']['tmp_name']));

        $query = "INSERT INTO `room`(`hotel_id`, `room_image`, `room_description`, `room_type`, `room_price`, `room_status`) VALUES ('$hotel', '$image', '$roomDescription', '$roomType', '$price', '$status')";
        if (mysqli_query($connection, $query)) {
            echo '<script>alert("New Room Added")</script>';
            echo '<script>window.location.href = "roomList.php";</script>';
        } else {
            echo '<script>alert("Sorry, Something Went Wrong. Please Try Again.")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Basic Styling */
        html, body {
            background: linear-gradient(45deg, #49a09d, #5f2c82);
            height: 100%;
            width: 100%;
            margin: 0;
        }

        .menubar{
            width: 100%;
            top: 0;
            position: relative;
            left: 0;
            z-index: 9999;
            box-shadow: 0 2px 4px 0 rgba(0,0,0,.2);
        }

        .container {
            max-width: 1200px;
            margin: -20px auto 0;
            padding: 15px;
            display: grid;
            grid-template-columns: 65% 35%;
            grid-gap: 20px;
            font-family: 'Roboto', sans-serif;
        }

        /* Columns */
        .left-column {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .left-column img {
            max-width: 80%;
            max-height: 80%;
            margin-left: 24%;
        }

        .room-image{
            width: 80%;
            height: 60%;
        }
        
        .right-column {
            width: 35%;
            margin-top: 60px;
        }

        /* Product Description */
        .room_description {
            border-bottom: 1px solid #E1E8EE;
            margin-bottom: 20px;
            width: 400px;
        }
        
        .room_description .name {
            font-size: 30px;
            color: #358ED7;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: none;
        }
        
        .room_description h1 {
            font-weight: 300;
            font-size: 52px;
            color: white;
            letter-spacing: -2px;
        }
        
        .room_description p {
            font-size: 16px;
            font-weight: 300;
            color: #c0c0c0;
            line-height: 24px;
        }
        
        .part {
            border-bottom: 1px solid #E1E8EE;
            margin-bottom: 20px;
            width: 400px;
        }

        .price {
            display: flex;
            align-items: center;
        }
        
        .price span {
            font-size: 26px;
            font-weight: 300;
            color: #c0c0c0;
            margin-right: 20px;
        }
        
        .add_btn {
            border: none;
            margin-left: 20px;
            display: inline-block;
            background-color: #7DC855;
            border-radius: 6px;
            font-size: 16px;
            color: #FFFFFF;
            text-decoration: none;
            padding: 12px 30px;
            cursor: pointer;
            transition: all .5s;
        }
        
        .add_btn:hover {
            background-color: teal;
        }

        .cancel_btn {
            border: none;
            display: inline-block;
            background-color: red;
            border-radius: 6px;
            font-size: 16px;
            color: #FFFFFF;
            text-decoration: none;
            padding: 12px 30px;
            cursor: pointer;
            transition: all .5s;
        }
        
        .cancel_btn:hover {
            background-color: orange;
        }

        // gradient animation
        @keyframes gradient { 
            0%{background-position:0 0}
            100%{background-position:100% 0}
        }

        .webflow-style-input {
            margin-bottom: 20px;
            position: relative;
            display: flex;
            flex-direction: row;
            width: 60%;
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

        .webflow-style-input:hover{
            background: rgba(57, 63, 84, 0.8);
            width: 80%;
        }

        .webflow-style-input:focus{
            background: rgba(57, 63, 84, 0.8);
            padding-left:80px;  
            margin-left:35px;
            outline: none;
        }

        .webflow-style-input input {
            flex-grow: 1;
            color: #BFD2FF;
            font-size: 15px;
            line-height: 20px;
            vertical-align: middle;
            &::-webkit-input-placeholder {
                color: #57E6E6;
            }
        }

        .webflow-style-input2 {
            margin-bottom: 20px;
            position: relative;
            display: flex;
            flex-direction: row;
            width: 35%;
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

        .webflow-style-input2:hover{
            background: rgba(57, 63, 84, 0.8);
            width: 45%;
            transition: all 0.5s ease-in-out;
        }

        .webflow-style-input2:focus{
            background: rgba(57, 63, 84, 0.8);
            padding-left:80px;  
            margin-left:35px;
            outline: none;
            transition: all 0.5s ease-in-out;
        }

        .webflow-style-input2 input {
            flex-grow: 1;
            color: #BFD2FF;
            font-size: 15px;
            line-height: 20px;
            vertical-align: middle;
            &::-webkit-input-placeholder {
                color: #FEFFB8;
            }
        }

        .webflow-style-input2 select {
            flex-grow: 1;
            color: #BFD2FF;
            font-size: 15px;
            line-height: 20px;
            vertical-align: middle;
            &::-webkit-input-placeholder {
                color: #FEFFB8;
            }
        }

        .webflow-style-input2 option {
            flex-grow: 1;
            color: rgb(4, 153, 131);
        }

        .input{
            background-color: transparent;
            border: none;
            font-size: 15px;
        }

        .input:focus{
            outline: none;
        }

        .select{
            background-color: transparent;
            border: none;
            font-size: 15px;
            color: grey;
        }

        .select:focus{
            outline: none;
        }

        .word3{
            color: white;
        }

    </style>
</head>
<body>
    <div class="menubar">
        <?php include "menubar.php"; ?>
    </div>

<form action="#" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">
    <main class="container">
    
    <!-- Left Column / Headphones Image -->
    <div class="left-column">
        <div class="word3">Room Image</div>
        <br/>
        <div class="room-image"><img id="imagePreview" src="#" alt="Preview" style="display: none;"></div>
        <div><input type="file" name="RoomImage" onchange="previewImage(event)"></div>
    </div>

    <!-- Right Column -->
    <div class="right-column">
        <!-- Product Description -->
        <div class="room_description">
        <span class="name"><?php echo $_SESSION['hotelID'];?> <?php echo $_SESSION['hotelName'];?></span>
        <input type="hidden" name="hotelID" value="<?php echo $_SESSION['hotelID'];?>">
        <p></p>
        </div>

        <!-- Product Configuration -->
        <div class="product-configuration">

        <div class="part">
        <span class="word3">Room Description:</span>
            <div class="webflow-style-input">
            <input class="input" type="text" name="RoomDescription" placeholder="Description">
            </div>
            <br/>

        <span class="word3">Room Type:</span>
            <div class="webflow-style-input2">
                <select class="select" name="RoomType">
                    <option value="Single Room">Single Room</option>
                    <option value="Double Room">Double Room</option>
                    <option value="Triple Room">Triple Room</option>
                    <option value="President Room">President Suite</option>
                </select>
            </div>  
            <br/>

            <span class="word3">Unit Price (RM)/Day:</span>
            <div class="webflow-style-input2">
                <input class="input" type="decimal" name="RoomPrice" placeholder="$$$">
            </div>
            <br/>

            <input type="hidden" name="RoomStatus" value="Available">

            </div>

        <div class="price">
            <input type="button" value="Back" onclick="history.back()" class="cancel_btn">
            <input id="btnAdd" type="submit" value="Add Room" name="btnAdd" class="add_btn">
        </div>

        </div>
    </div>
    </main>
</form>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var imgElement = document.getElementById('imagePreview');
            imgElement.src = reader.result;
            imgElement.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }

</script>
</body>
</html>
