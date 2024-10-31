<?php
session_start();
include 'dbConn.php';
$roomID=$_GET['roomID'];

if (isset($_POST['btnUpdate'])){
    $description = $_POST['RoomDescription'];
    $type = $_POST['RoomType'];
    $price = $_POST['RoomPrice'];
    $status = $_POST['RoomStatus'];
    // $stock = $_POST['txtStock'];
    $updateQuery = "UPDATE `room` SET `room_description`='$description',`room_type`='$type',`room_price`='$price', `room_status`='$status' WHERE room_id='$roomID'";
    if (mysqli_query($connection, $updateQuery)){
        echo "<script>";
        echo "alert('Room Updated Successfully');";
        echo "window.location = 'roomList.php';";
        echo "</script>";
    } 
    else {
        echo 'Sorry, Something Went Wrong. Please Try Again.';
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
        *{
            margin: 0;
            padding: 0;
            font-family:'Poppins', sans-serif;
            box-sizing: border-box;
        }

        .container{
            width: 100%;
            min-height: 100vh;
            background: #d0eaff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .room{
            width: 90%;
            max-width: 750px;
            display: flex;
        }

        .image{
            flex-basis: 47%;
            /* background: #241e20; */
            transform: scale(1.08);
            box-shadow: -10px 5px 10px 10px rgba(0, 0, 0, 0.1);
            /* justify-content: center; */
        }
        
        .image img{
            /* width: 100%; */
            display: block;
            /* padding-top: 100px; */
        }

        .detail{
            flex-basis: 53%;
            background: white;
            padding: 40px;
            padding-left: 60px;
            box-shadow: -10px 5px 10px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<?php
     $query = "SELECT * FROM room WHERE room.room_id='$roomID'";
     $result = mysqli_query($connection, $query);
     $row = mysqli_fetch_assoc($result); //$row[0]; $row['email']
     $count = mysqli_num_rows($result); //1 or 0
     if ($count ==1){
     ?>

    <div class="container">
        <div class="room">
            <div class="image">
                <?php
                    if (!empty($row['room_image'])) {
                        echo '<img id="imagePreview" src="data:image;base64,' . base64_encode($row['room_image']) . '" height="175" width="175">';
                    } else {
                        echo 'No image available';
                    }
                ?></br>
                <button type="button" onclick="resetImage()">Reset Image</button>
                <input type="file" name="RoomImage" id="roomImage" onchange="previewImage(event)">
            </div>
            <div class="detail">
                <h1>
                    <?php echo $_SESSION['hotelID'];?> <?php echo $_SESSION['hotelName'];?>
                    <input type="hidden" name="HotelID" value="<?php echo $_SESSION['hotelID'];?> ">
                </h1>
                <h2>
                    <?php echo $row['room_id'];?>
                    <input type="hidden" name="HotelID" value="<?php echo $row['room_id'];?> ">
                </h2>
                <h3>
                Room Type : 
                <select name="RoomType">
                            <option value="<?php echo $row['room_type']; ?>"><?php echo $row['room_type']; ?></option>
                            <option value="Single Room">Single Room</option>
                            <option value="Double Room">Double Room</option>
                            <option value="Triple Room">Triple Room</option>
                            <option value="President Room">President Suite</option>
                        </select>
                </h3>
                <p><input type="text" name="RoomDescription" value="<?php echo $row['room_description']; ?> "></p>
            </div>
        </div>
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