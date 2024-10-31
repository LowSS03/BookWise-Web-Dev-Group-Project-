<?php
session_start();
include 'dbConn.php';

if (isset($_POST['btnChange1'])) {
    $newHotelEmail = $_POST['newEmail'];
    $newHotelNotel = $_POST['newNotel'];
    $newHotelPassword = $_POST['newPassword'];
    $newHotelAddress = $_POST['newAddress'];
    $newHotelPostcode = $_POST['newPostcode'];
    $newHotelState = $_POST['newState'];

    // Check if the uploaded image is the default image
    if (isset($_FILES['HotelImage']) && $_FILES['HotelImage']['error'] === UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES['HotelImage']['tmp_name']);

        // Prepare the update query with a placeholder for the image data
        $updateQuery = "UPDATE `hotel` SET `hotel_email`=?, `hotel_notel`=?, `hotel_password`=?, `address`=?, `postcode`=?, `state`=?, `hotel_image`=? WHERE hotel_id=?";
        
        // Create a prepared statement
        $stmt = mysqli_prepare($connection, $updateQuery);
        
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "sssssssi", $newHotelEmail, $newHotelNotel, $newHotelPassword, $newHotelAddress, $newHotelPostcode, $newHotelState, $imageData, $_SESSION['hotelID']);
        
        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>";
            echo "alert('Room Updated Successfully');";
            echo "window.location = 'viewBooking.php';";
            echo "</script>";
            exit; // Exit the script after redirecting
        } else {
            echo 'Sorry, something went wrong.';
        }
    } else {
        // The image was not uploaded, so only update the non-image fields
        $updateQuery = "UPDATE `hotel` SET `hotel_email`=?, `hotel_notel`=?, `hotel_password`=?, `address`=?, `postcode`=?, `state`=? WHERE hotel_id=?";
        
        // Create a prepared statement
        $stmt = mysqli_prepare($connection, $updateQuery);
        
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ssssssi", $newHotelEmail, $newHotelNotel, $newHotelPassword, $newHotelAddress, $newHotelPostcode, $newHotelState, $_SESSION['hotelID']);
        
        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>";
            echo "alert('Room Updated Successfully');";
            echo "window.location = 'viewBooking.php';";
            echo "</script>";
            exit; // Exit the script after redirecting
        } else {
            echo 'Sorry, something went wrong.';
        }
    }
}
?>




<!-- Rest of the HTML code remains the same -->



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            margin: 0;
            background-image: url("image/background10.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            overflow: hidden;
            z-index: -1;
        }

        .menubar {
            width: 100%;
            top: 0;
            position: relative;
            left: 0;
            z-index: 9999;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .2);
        }

        .sidenav {
            background-color: #fff;
            color: #333;
            border-bottom-right-radius: 25px;
            height: 86%;
            left: 0;
            overflow-x: hidden;
            padding-top: 20px;
            position: absolute;
            top: 70px;
            width: 250px;
        }

        .profile {
            margin-bottom: 20px;
            margin-top: -12px;
            text-align: center;
        }

        .profile img {
            border-radius: 50%;
            box-shadow: 0px 0px 5px 1px grey;
        }

        .id {
            font-size: 20px;
            font-weight: bold;
            padding-top: 20px;
        }

        .name {
            font-size: 16px;
            font-weight: bold;
            padding-top: 10px;
        }

        .url,
        hr {
            text-align: center;
        }

        .url hr {
            margin-left: 20%;
            width: 60%;
        }

        .url a {
            color: #818181;
            display: block;
            font-size: 20px;
            margin: 10px 0;
            padding: 6px 8px;
            text-decoration: none;
        }

        .url a:hover,
        .url .active {
            background-color: #e8f5ff;
            border-radius: 28px;
            color: #000;
            margin-left: 14%;
            width: 65%;
        }

        /* End */

        /* Main */
        .main {
            font-family: Arial;
            margin-top: 2%;
            margin-left: 20%;
            font-size: 28px;
            padding: 0 10px;
            width: 58%;
        }

        .main h2 {
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 30px;
            margin-bottom: 10px;
        }

        .main .card {
            background-image: url("image/background11.webp");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            border-radius: 18px;
            box-shadow: 1px 1px 8px 0 grey;
            height: auto;
            margin-bottom: 20px;
            padding: 20px 0 20px 50px;
        }

        .main .card table {
            border: none;
            font-size: 16px;
            height: 350px;
            width: 80%;
        }

        /* .edit {
            position: absolute;
            color: #e7e7e8;
            right: 14%;
        } */

        button,
        input[type="file"] {
            margin-top: 10px;
        }

        .hotel-image{
            margin-top: -8%;
            margin-left: 22%;
            width: 50%;
            height: 250px;
            text-align: center;
            box-shadow: 0 0 8px black;
            clip-path: inset(-10px -10px -10px -10px);
            z-index: 30;
            background-color: grey;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .button input[type=file]::file-selector-button{
            background: transparent;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        .button input[type=file]::file-selector-button:hover{
            background: green;
            color: white;
            border: none;
            cursor: pointer;
        }

        .reset{
            background: transparent;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        .reset:hover{
            background: red;
            color: white;
            border: none;
            cursor: pointer;
        }

        .save{
            width: 100px;
            height: 50px;
            border: none;
            cursor: pointer;
            border-radius: 20px;
            box-shadow: 1px 1px 8px 0 grey;
        }

        .save:hover{
            background-color: rgba(177, 177, 177);
        }



        /* End */
    </style>
</head>

<body>

    <?php
    $query = "SELECT * FROM hotel WHERE hotel_id=" . $_SESSION["hotelID"];
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $count = mysqli_num_rows($result);
    if ($count == 1) {
    }
    ?>

    <div class="menubar">
        <?php include "menubar.php"; ?>
    </div>

    <div class="main">
        <form action="#" method="POST" enctype="multipart/form-data">
            <h2>PROFILE</h2>
            <div class="card">
                <div class="card-body">
                            <div class="hotel-image">
                                <div class="image">
                                    <?php
                                    if (!empty($row['hotel_image'])) {
                                        echo '<img id="imagePreview" src="data:image;base64,' . base64_encode($row['hotel_image']) . '" height="200" width="100%">';
                                    } else {
                                        echo 'No image available';
                                    }
                                    ?>
                                </div>
                                <div class="button">
                                    <button class="reset" type="button" onclick="resetImage()">Reset Image</button>
                                    <input type="file" name="HotelImage" id="hotelImage" onchange="previewImage(event)">
                                </div>
                            </div>
                            <br/>
                    <table>

                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td><?php echo $row['hotel_name']; ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><input type="text" name="newEmail" value="<?php echo $row['hotel_email']; ?>"></td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td>:</td>
                                <td><input type="text" name="newPassword" value="<?php echo $row['hotel_password']; ?>"></td>
                            </tr>
                            <tr>
                                <td>Phone Number</td>
                                <td>:</td>
                                <td><input type="text" name="newNotel" value="<?php echo $row['hotel_notel']; ?>"></td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td><input type="text" name="newAddress" value="<?php echo $row['address']; ?>"></td>
                            </tr>
                            <tr>
                                <td>Postcode</td>
                                <td>:</td>
                                <td><input type="text" name="newPostcode" value="<?php echo $row['postcode']; ?>"></td>
                            </tr>
                            <tr>
                                <td>State</td>
                                <td>:</td>
                                <td>
                                    <select name="newState">                    
                                        <option value="<?php echo $row['state']; ?>"><?php echo $row['state']; ?></option>
                                        <option value="Johor">Johor</option>
                                        <option value="Kedah">Kedah</option>
                                        <option value="Kelantan">Kelantan</option>
                                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                                        <option value="Labuan">Labuan</option>
                                        <option value="Melaka">Melaka</option>
                                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                                        <option value="Pahang">Pahang</option>
                                        <option value="Penang">Penang</option>
                                        <option value="Perak">Perak</option>
                                        <option value="Perlis">Perlis</option>
                                        <option value="Putrajaya">Putrajaya</option>
                                        <option value="Sabah">Sabah</option>
                                        <option value="Sarawak">Sarawak</option>
                                        <option value="Selangor">Selangor</option>
                                        <option value="Terengganu">Terengganu</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><button class="save" type="submit" name="btnChange1">Save</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>

    <script>
        var originalImage = <?php echo json_encode(base64_encode($row['hotel_image'])); ?>; // Store the original image data as base64 encoded string
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
            document.getElementById('hotelImage').value = ''; // Reset the file input value
        }
    </script>
</body>

</html>
