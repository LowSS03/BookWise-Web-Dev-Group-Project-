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
        $query = "SELECT * FROM booking 
        INNER JOIN room ON booking.room_id=room.room_id
        INNER JOIN customer ON booking.customer_id=customer.customer_id 
        INNER JOIN hotel ON booking.hotel_id=hotel.hotel_id
        WHERE room.room_type='$roomType' AND booking.hotel_id=" . $_SESSION["hotelID"];
    } else {
        $query = "SELECT * FROM booking 
        INNER JOIN customer ON booking.customer_id=customer.customer_id 
        INNER JOIN room ON booking.room_id=room.room_id
        INNER JOIN hotel ON booking.hotel_id=hotel.hotel_id
        WHERE booking.hotel_id=" . $_SESSION["hotelID"];
    }
} else {
    $roomType = "All"; // Set default value to "All"
    $query = "SELECT * FROM booking 
    INNER JOIN customer ON booking.customer_id=customer.customer_id 
    INNER JOIN room ON booking.room_id=room.room_id
    INNER JOIN hotel ON booking.hotel_id=hotel.hotel_id";
}

// Check if the hotel name or customer name search value is set
if (isset($_POST['nametf']) && !empty($_POST['nametf'])) {
    $searchValue = sanitize($_POST['nametf']);
    $query .= " AND (hotel.hotel_name LIKE '%$searchValue%' OR customer.customer_name LIKE '%$searchValue%')";
}

// Add sorting functionality
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'booking_id';
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
        /* CSS styles here */
    </style>
</head>
<body>
    <div class="menubar">
        <?php include "menubar.php"; ?>
    </div>
    <form action="#" method="POST">
        <select class="custom-select" name="roomType" onchange="this.form.submit()">
            <option value="All" <?php if ($roomType == 'All') { echo 'selected'; } ?>>All</option>
            <option value="Single Room" <?php if ($roomType == 'Single Room') { echo 'selected'; } ?>>Single Room</option>
            <option value="Double Room" <?php if ($roomType == 'Double Room') { echo 'selected'; } ?>>Double Room</option>
            <option value="Triple Room" <?php if ($roomType == 'Triple Room') { echo 'selected'; } ?>>Triple Room</option>
            <option value="President Room" <?php if ($roomType == 'President Room') { echo 'selected'; } ?>>President Room</option>
        </select>
        <input id="nametf" type="text" name="nametf" list="searchResults" value="<?php echo $searchValue; ?>">
        <datalist id="searchResults"></datalist>
        <button type="submit">Search</button>
    </form>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><a href="?sort=booking_id&order=<?php echo ($sortColumn === 'booking_id' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>">Booking ID</a></th>
                <th><a href="?sort=hotel_name&order=<?php echo ($sortColumn === 'hotel_name' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>">Hotel Name</a></th>
                <th><a href="?sort=customer_name&order=<?php echo ($sortColumn === 'customer_name' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>">Customer Name</a></th>
                <th>Room Type</th>
                <th>Check-in Date</th>
                <th>Check-out Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['booking_id'] . '</td>';
                echo '<td>' . $row['hotel_name'] . '</td>';
                echo '<td>' . $row['customer_name'] . '</td>';
                echo '<td>' . $row['room_type'] . '</td>';
                echo '<td>' . $row['check_in_date'] . '</td>';
                echo '<td>' . $row['check_out_date'] . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#nametf').on('input', function() {
            var searchValue = $(this).val();
            $.ajax({
                url: 'adminViewBooking.php', // Replace with the actual PHP script to handle the autocomplete search
                type: 'POST',
                data: { searchValue: searchValue },
                success: function(response) {
                    $('#searchResults').html(response);
                }
            });
        });
    });
    </script>
</body>
</html>
