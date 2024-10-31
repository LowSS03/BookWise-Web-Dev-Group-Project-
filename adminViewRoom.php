<?php
session_start();
include 'dbConn.php';

// Function to sanitize user input
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['roomType'])) {
    $roomType = sanitize($_POST['roomType']);
    if ($roomType !== "All") {
        $query = "SELECT * FROM room 
        INNER JOIN hotel ON room.hotel_id=hotel.hotel_id
        WHERE room.room_type='$roomType'";
    } else {
        $query = "SELECT * FROM room 
        INNER JOIN hotel ON room.hotel_id=hotel.hotel_id";
    }
} else {
    $roomType = "All"; // Set default value to "All"
    $query = "SELECT * FROM room 
    INNER JOIN hotel ON room.hotel_id=hotel.hotel_id";
}

// Check if the hotel name search value is set
if (isset($_POST['nametf']) && !empty($_POST['nametf'])) {
    $searchTerm = sanitize($_POST['nametf']);
    $query .= " AND hotel.hotel_name LIKE '%$searchTerm%'";
}


// Add sorting functionality
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'room_id';
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


.roomTable {
    font-family: sans-serif;
    font-weight: 100;
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.all-table{
            font-family: sans-serif;
            font-weight: 100;
            position: relative;
            margin-top: 10px;
            left: 0;
        }

.all-table {
    font-family: sans-serif;
    font-weight: 100;
    position: relative;
    margin-top: 10px;
    left: 0;
}
.roomTable th, .roomTable td{
    padding: 15px;
    background-color: rgba(255,255,255,0.2);
    text-align: center;
    color: white;
}

.roomTable tbody:hover td {
    color: transparent;
    text-shadow: 0 0 3px #aaa;
}

.roomTable tbody:hover tr:hover td {
    text-shadow: 0 1px 0 white;
}

.roomTable th {
    background-color: #55608f;
}

.roomTable tr:hover {
    background-color: rgba(255,255,255,0.3);
}

.roomTable tr.title2 {
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
    font-size: 12px; /* Updated font size */
}

.button:hover {
    background-color: rgba(0, 128, 128, 0.8); 
}

.custom-select{
    border: 0;
    background: none;
    display: block;
    /* margin: 20px auto; */
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

        .input{
            background-color: transparent;
            border: none;
            font-size: 15px;
        }

        .input:focus{
            outline: none;
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

</style>
</head>
<body>
    <div class="menubar">
        <?php include "menubar.php"; ?>
    </div>
    <div class="all-table">
    <form action="#" method="POST">
            <select class="custom-select" name="roomType" onchange="this.form.submit()">
                <option value="All" <?php if($roomType == 'All') { echo 'selected'; } ?>>All</option>
                <option value="Single Room" <?php if($roomType == 'Single Room') { echo 'selected'; } ?>>Single Room</option>
                <option value="Double Room" <?php if($roomType == 'Double Room') { echo 'selected'; } ?>>Double Room</option>
                <option value="Triple Room" <?php if($roomType == 'Triple Room') { echo 'selected'; } ?>>Triple Room</option>
                <option value="President Room" <?php if($roomType == 'President Room') { echo 'selected'; } ?>>President Room</option>
            </select>
            <div class="searchname">
                <input class = "input" type="text" name="nametf" placeholder="Search Name">
            </div>
    </form>

    <table class="roomTable">
        <tr class="title2">
            <th>Room ID</th>
            <th>Hotel Name</th>
            <th>Room Image</th>
            <th>Room Description</th>
            <th>Room Type</th>
            <th>Room Price</th>
            <th align="center">Option</th>
        </tr>

        <?php
            if(mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
        ?>

        <tr>
            <td><?php echo $row['room_id']; ?></td>
            <td><?php echo $row['hotel_name']; ?></td>
            <td><?php echo '<img src="data:image;base64,' . base64_encode($row['room_image']) . '" height="150" width="150">';?></td>
            <td><?php echo $row['room_description']; ?></td>
            <td><?php echo $row['room_type']; ?></td>
            <td><?php echo $row['room_price']; ?></td>
            <td align="center">
                <div class="button-container">
                    <a href="adminEditRoom.php?roomID=<?php echo $row['room_id']; ?>" class="button">Edit 📝</a>
                    <a href="adminDeleteBooking.php?roomID=<?php echo $row['room_id']; ?>" class="button">Delete 🗑️</a>
                </div>
            </td>
        </tr>

        <?php
             }}else{
                echo '<tr><td style="padding:8px; text-transform:capitalize; text-align:center;" colspan="20"; ><h2>No Bookings have been made.</h2></td></tr>';
            }
            mysqli_close($connection);
        ?>


    </table>
</div>
</body>
</html>
</body>

</html>