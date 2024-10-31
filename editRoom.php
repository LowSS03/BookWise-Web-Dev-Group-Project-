<?php
session_start();
include 'dbConn.php';
$roomID = $_GET['roomID'];

if (isset($_POST['btnUpdate'])) {
    $description = $_POST['RoomDescription'];
    $type = $_POST['RoomType'];
    $price = $_POST['RoomPrice'];
    $status = $_POST['RoomStatus'];

    if (isset($_FILES['RoomImage']) && $_FILES['RoomImage']['error'] === UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES['RoomImage']['tmp_name']);

        // Prepare the update query with a placeholder for the image data
        $updateQuery = "UPDATE `room` SET `room_description`=?, `room_type`=?, `room_price`=?, `room_status`=?, `room_image`=? WHERE room_id=?";
        
        // Create a prepared statement
        $stmt = mysqli_prepare($connection, $updateQuery);
        
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "sssssi", $description, $type, $price, $status, $imageData, $roomID);
        
        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>";
            echo "alert('Room Updated Successfully');";
            echo "window.location = 'roomList.php';";
            echo "</script>";
        } else {
            echo 'Sorry, Something Went Wrong. Please Try Again.';
        }
    } else {
        // The image was not uploaded, so only update the non-image fields
        $updateQuery = "UPDATE `room` SET `room_description`=?, `room_type`=?, `room_price`=?, `room_status`=? WHERE room_id=?";
        
        // Create a prepared statement
        $stmt = mysqli_prepare($connection, $updateQuery);
        
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ssssi", $description, $type, $price, $status, $roomID);
        
        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>";
            echo "alert('Room Updated Successfully');";
            echo "window.location = 'roomList.php';";
            echo "</script>";
        } else {
            echo 'Sorry, Something Went Wrong. Please Try Again.';
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
        body, html {
            height: 100%;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        .img4{
            filter: blur(6px);
            -webkit-filter: blur(3px);
            background-image: url("image/background9.jpg");
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .container{
            position: absolute;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 999;
            height: 70%;
            width: 80%;
            padding: 20px;
            text-align: center;
        }

        h2{
            font-size: 50px;
        }

        .left{
            position: absolute;
            width: 45%;
            height: 85%;
            margin-left: 10%;
            background-image: url("image/background11.webp");
            background-position: left;
            background-repeat: no-repeat;
            background-size: cover;
            box-shadow: 0 4px 4px 4px rgba(0,0,0,.2);
            z-index: 99;
            animation: flowleft 2s;
            color: white;
            font-size: 25px;
            text-align: left;
            padding: 0px 0px;
        }

        .hotel{
            text-align: center;
            width: 100%;
            height: 14%;
            background: rgb(6, 35, 94, 0.6);
        }

        .roomid, .roomimage{
            padding: 0 30px;
        }

        .roomimage button{
            background: transparent;
            border: none;
            color: white;
            transition: 0.3s ease-in-out;
            cursor: pointer;
            text-decoration: underline;
        }

        .roomimage button:hover{
            background: red;
            text-decoration: none;
        }

        .right{
            position: absolute;
            padding: 20px 0;
            width: 40%;
            height: 65%;
            margin-left: 45%;
            margin-top: 3%;
            background: linear-gradient(45deg, #49a09d, #5f2c82);
            box-shadow: 0 2px 4px 3px rgba(0,0,0,.2);
            z-index: 9;
            border-radius: 30px;
            animation: flowright 2s;
        }

        @keyframes flowleft{
            0%{
                opacity: 1;
                margin-left: 28%;
            }
            30%{
                opacity: 1;
                margin-left: 28%;
            }
            100%{
                opacity: 1;
                margin-left: 10%;
            }
        }

        @keyframes flowright{
            0%{
                opacity: 1;
                margin-left: 28%;
            }
            30%{
                opacity: 1;
                margin-left: 28%;
            }
            100%{
                opacity: 1;
                margin-left: 45%;
            }
        }

        .word{
            color: white;
            font-family: arial;
        }

        .description, .roomtype, .roomprice, .roomstatus{
            margin-left: 35%;
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

        .description:hover, .roomtype:hover, .roomprice:hover, .roomstatus:hover{
            background: rgba(57, 63, 84, 0.8);
            width: 45%;
            transition: all 0.5s ease-in-out;
        }

        .description:focus, .roomtype:focus, .roomprice:focus, .roomstatus:focus{
            background: rgba(57, 63, 84, 0.8);
            padding-left:80px;  
            margin-left:35px;
            outline: none;
            transition: all 0.5s ease-in-out;
        }

        .description input, .roomprice input {
            flex-grow: 1;
            color: #BFD2FF;
            font-size: 15px;
            line-height: 20px;
            vertical-align: middle;
            &::-webkit-input-placeholder {
                color: #FEFFB8;
            }
        }

        .roomtype select, .roomstatus select {
            flex-grow: 1;
            color: #BFD2FF;
            font-size: 15px;
            line-height: 20px;
            vertical-align: middle;
            &::-webkit-input-placeholder {
                color: #FEFFB8;
            }
        }

        .roomtype option, .roomstatus option {
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

        .btn1{
            position: absolute;
            background-color: lightgreen;
            text-align: right;
            width: 100px;
            height: 30px;
            left: 50%;
            margin-top: 26%;
            padding: 4px;
            transition: all 0.5s ease-in-out;
            animation: flowright2 2s forwards;
            cursor: pointer;
            border-radius: 20px;
            z-index: -1;
        }

        .btn2{
            position: absolute;
            background-color: red;
            text-align: right;
            width: 100px;
            height: 30px;
            left: 50%;
            margin-top: 22%;
            padding: 4px;
            transition: all 0.5s ease-in-out;
            animation: flowright2 2s forwards;
            cursor: pointer;
            border-radius: 20px;
            z-index: 1;
        }

        .btn1-style, .btn2-style{
            opacity: 0;
            transition: all 0.5s ease-in-out;
            border: none;
            background: transparent;
            color: white;
            width: 50%;
            cursor: pointer;
        }


        @keyframes flowright2{
            0%{
                opacity: 0;
                margin-left: 5%;
            }
            30%{
                opacity: 0;
                margin-left: 5%;
            }
            70%{
                opacity: 0;
                margin-left: 15%;
            }
            100%{
                opacity: 1;
                margin-left: 30%;
            }
        }

        .btn1:hover{
            width: 180px;
        }
        
        .btn1:hover .btn1-style{
            opacity: 1;
        }

        .btn2:hover{
            width: 180px;
        }

        .btn2:hover .btn2-style{
            opacity: 1;
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

    </style>
</head>
<body>
<div class="img4"></div>
    <div class="container">
        <h2>Room Information</h2>
            <?php
            $query = "SELECT * FROM room WHERE room.room_id='$roomID'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result); //$row[0]; $row['email']
            $count = mysqli_num_rows($result); //1 or 0
            if ($count ==1){
            ?>

        <form action="#" method="POST" enctype="multipart/form-data">
                <div class="left">
                    <div class="card-content2">
                        <div class="hotel">
                            <div class="hotelid">Hotel ID : 
                                <span>
                                    <?php echo $_SESSION['hotelID'];?>
                                    <input type="hidden" name="HotelID" value="<?php echo $_SESSION['hotelID'];?> ">
                                </span>
                            </div>  

                            <div class="hotelname">Hotel Name : 
                                <span>
                                    <?php echo $_SESSION['hotelName'];?>
                                </span>
                            </div> 
                        </div> 
                        </br>

                        <div class="roomid">Room ID : 
                            <span>
                                <?php echo $row['room_id'];?>
                                <input type="hidden" name="HotelID" value="<?php echo $row['room_id'];?> ">
                            </span>
                        </div>

                        <div class="roomimage">
                            <div class="image">
                                <?php
                                    if (!empty($row['room_image'])) {
                                        echo '<img id="imagePreview" src="data:image;base64,' . base64_encode($row['room_image']) . '" height="250px" width="450px">';
                                    } else {
                                        echo 'No image available';
                                    }
                                ?>
                                </br>
                                <button type="button" onclick="resetImage()">Reset Image</button>
                                <input type="file" name="RoomImage" id="roomImage" onchange="previewImage(event)">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="right">
                    <div class="word">Room Description : 
                        <div class="description">
                            <input class="input" type="text" name="RoomDescription" value="<?php echo $row['room_description']; ?> ">
                        </div>
                    </div>
                    </br>

                    <div class="word">Room Type :
                        <div class="roomtype">
                            <select class="select" name="RoomType">
                                <option value="<?php echo $row['room_type']; ?>"><?php echo $row['room_type']; ?></option>
                                <option value="Single Room">Single Room</option>
                                <option value="Double Room">Double Room</option>
                                <option value="Triple Room">Triple Room</option>
                                <option value="President Room">President Suite</option>
                            </select>
                        </div>
                    </div>
                    </br>

                    <div class="word">Room Price : 
                        <div class="roomprice">
                            <input class="input" type="decimal" name="RoomPrice" value="<?php echo $row['room_price']; ?> ">
                        </div>
                    </div>
                    </br>

                    <div class="word">Room Status : 
                        <div class="roomstatus">
                            <select class="select" name="RoomStatus">
                                <option value="<?php echo $row['room_status']; ?>"><?php echo $row['room_status']; ?></option>
                                <option value="Available">Available</option>
                                <option value="Occupied">Occupied</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                    <div class="btn2">
                        <a href="roomList.php"><input class="btn2-style" type="button" value="Back" id="btn" onclick="history.go(-1)"></a>
                    </div>
                    <div class="btn1">
                        <input class="btn1-style" type="submit" value="Update" name="btnUpdate">
                    </div>

            </form>
    </div>

    <?php
    }
    else{
    echo 'Record Not Found.';
    }
    ?>
    <script>
        var originalImage = <?php echo json_encode(base64_encode($row['room_image'])); ?>; // Store the original image data as base64 encoded string
        var currentImage = originalImage; // Store the current image data

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var imgElement = document.getElementById('imagePreview');
                imgElement.src = reader.result;
                currentImage = null; // Reset the current image data since a new image is selected
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function resetImage() {
            var imgElement = document.getElementById('imagePreview');
            if (originalImage) {
                imgElement.src = 'data:image;base64,' + originalImage;
                currentImage = originalImage; // Restore the original image data
            } else {
                imgElement.src = ''; // Clear the image source if no original image is available
            }
            document.getElementById('roomImage').value = ''; // Reset the file input value
        }
    </script>

</body>
</html>