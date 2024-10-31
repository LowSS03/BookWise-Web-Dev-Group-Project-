<?php
session_start();
include 'dbConn.php';
$query = "SELECT * FROM hotel";

if (isset($_POST['saveBtn'])) {
    $hotelID = $_POST['hotelID'];
    $newHotelName = $_POST['newHotelName'];
    $newHotelEmail = $_POST['newHotelEmail'];
    $newHotelNotel = $_POST['newHotelNotel'];
    $newHotelPassword = $_POST['newHotelPassword'];
    $newHotelAddress = $_POST['newHotelAddress'];
    $newHotelPostcode = $_POST['newHotelPostcode'];
    $newHotelState = $_POST['newHotelState'];
    $updateQuery = "UPDATE `hotel` SET `hotel_name`='$newHotelName', `hotel_email`='$newHotelEmail', `hotel_notel`='$newHotelNotel', `hotel_password`='$newHotelPassword', `address`='$newHotelAddress', `postcode`='$newHotelPostcode', `state`='$newHotelState' WHERE hotel_id='$hotelID'";
    if (mysqli_query($connection, $updateQuery)) {
        echo "<script>";
        echo "alert('Hotel Updated Successfully');";
        echo "window.location = 'adminViewHotel.php';";
        echo "</script>";
    } else {
        echo '<script>alert("Something went wrong, sorry...")</script>';
    }
}

// Function to sanitize user input
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the hotel name search value is set
if (isset($_POST['nametf']) && !empty($_POST['nametf'])) {
    $searchTerm = sanitize($_POST['nametf']);
    $query .= " WHERE hotel.hotel_name LIKE '%$searchTerm%'";
}



// Add sorting functionality
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'hotel_id';
$sortOrder = isset($_GET['order']) ? $_GET['order'] : 'ASC';

$query .= " ORDER BY $sortColumn $sortOrder";

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
        /* Styles */

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
            background: linear-gradient(45deg, #49a09d, #5f2c82);
        }

        .all-table{
            font-family: sans-serif;
            font-weight: 100;
            position: relative;
            margin-top: 10px;
            left: 0;
        }

        .hotelTable {
            font-family: sans-serif;
            font-weight: 100;
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .hotelTable th,
        .hotelTable td {
            background-color: rgba(255, 255, 255, 0.2);
            text-align: center;
            color: white;
            overflow: hidden; 
            text-overflow: ellipsis; 
            word-wrap: break-word;
        }

        .hotelTable tbody:hover td {
            color: transparent;
            text-shadow: 0 0 3px #aaa;
        }

        .hotelTable tbody:hover tr:hover td {
            text-shadow: 0 1px 0 white;
        }

        .hotelTable th {
            background-color: #55608f;
        }

        .hotelTable tr:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .hotelTable tr.title2 {
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
            border: none;
        }

        .button:hover {
            background-color: rgba(0, 128, 128, 0.8);
        }

        .input {
            background-color: transparent;
            border: none;
            font-size: 15px;
            outline: none;
        }

        .inputHotel{
            background-color: transparent;
            border: none;
            font-size: 15px;
            color: white;
            text-align: center;
            width: 100px;
            transition: 0.2s ease-in;
        }

        .inputHotel:hover{
            background-color: rgb(0, 0, 0, 0.6);
        }

        .inputHotel:focus{
            border: none;
            outline: none;
            background-color: rgb(0, 0, 0, 0.6);
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

        .searchname{
            margin-left: 2%;
            position: relative;
            display: flex;
            flex-direction: row;
            width: 20%;
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

        .searchname:hover{
            background: rgba(57, 63, 84, 0.8);
            width: 30%;
            transition: all 0.5s ease-in-out;
        }

        .searchname:focus{
            background: rgba(57, 63, 84, 0.8);
            padding-left:80px;  
            margin-left:35px;
            outline: none;
            transition: all 0.5s ease-in-out;
        }

        .searchname input{
            flex-grow: 1;
            color: #BFD2FF;
            font-size: 15px;
            line-height: 20px;
            vertical-align: middle;
            &::-webkit-input-placeholder {
                color: #FEFFB8;
            }
        }
        .custom-select{
            border: 0;
            background: none;
            display: block;
            /* margin: 20px auto; */
            text-align: center;
            border: 2px solid #3498db;
            height: 40px;
            width: 125px;
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
            /* width: 150px; */
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
    <div class="menubar">
        <?php include "menubar.php"; ?>
    </div>
    <div class="all-table">
    <form action="#" method="POST">
        <div class="searchname">
            <input class="input" type="text" name="nametf" placeholder="Search Name">
        </div>
    </form>

        <table class="hotelTable">
            <tr class="title2">
                <th>Hotel ID</th>
                <th>Hotel Name</th>
                <th>Hotel Image</th>
                <th>Hotel Email</th>
                <th>Hotel Password</th>
                <th>Hotel Phone Number</th>
                <th>Hotel Address</th>
                <th>Hotel Postcode</th>
                <th>Hotel State</th>
                <th>Rating</th>
                <th align="center">Option</th>
            </tr>

            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>

            <tr>
                <form action="#" method="POST">
                    <td>
                        <?php echo $row['hotel_id']; ?>
                        <input class="inputHotel" type="hidden" name="hotelID" value="<?php echo $row['hotel_id']; ?>">
                    </td>
                    <td><input class="inputHotel" type="text" name="newHotelName" value="<?php echo $row['hotel_name']; ?>"></td>
                    <td><?php echo '<img src="data:image;base64,' . base64_encode($row['hotel_image']) . '" height="60" width="60">';?></td>
                    <td><input class="inputHotel" type="text" name="newHotelEmail" value="<?php echo $row['hotel_email']; ?>"></td>
                    <td><input class="inputHotel" type="text" name="newHotelPassword" value="<?php echo $row['hotel_password']; ?>"></td>
                    <td><input class="inputHotel" type="text" name="newHotelNotel" value="<?php echo $row['hotel_notel']; ?>"></td>
                    <td><input class="inputHotel" type="text" name="newHotelAddress" value="<?php echo $row['address']; ?>"></td>
                    <td><input class="inputHotel" type="text" name="newHotelPostcode" value="<?php echo $row['postcode']; ?>"></td>
                    <td><select class="custom-select" name="newHotelState">                    
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
                    <td><input class="inputHotel" type="text" name="newHotelRating" value="<?php echo $row['rating']; ?>"></td>
                    <td align="center">
                        <div class="button-container">
                            <a href=""><button class="button" type="submit" name="saveBtn">Save 📝</button></a>
                            <a href="adminDeleteHotel.php?hotelID=<?php echo $row['hotel_id']; ?>" class="button">Delete 🗑️</a>
                        </div>
                    </td>
                </form>
            </tr>

            <?php
                }
            } else {
                echo '<tr><td style="padding:8pxpx; text-transform:capitalize; text-align:center;" colspan="20"; ><h2>No Bookings have been made.</h2></td></tr>';
            }
            mysqli_close($connection);
            ?>


        </table>
</div>
</body>

</html>
</body>

</html>