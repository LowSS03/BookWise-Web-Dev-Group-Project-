<?php
session_start();
include 'dbConn.php';

if (isset($_SESSION['custID'])) {
    header("Location: viewBookingCustomer.php");
}

if (isset($_POST['roomType'])) {
    $roomType = $_POST['roomType'];
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
    INNER JOIN hotel ON booking.hotel_id=hotel.hotel_id
    WHERE booking.hotel_id=" . $_SESSION["hotelID"];
}


if (isset($_POST['markPaid'])) {
    $bookingID = $_POST['bookingID'];
    
    // Update the payment status to "Paid"
    $query = "UPDATE booking SET payment_status='Paid' WHERE booking_id='$bookingID'";
    if (mysqli_query($connection, $query)) {
        echo '<script>alert("Payment status updated to Paid.")</script>';
        echo '<script>window.location.href = "viewBookingCustomer.php";</script>'; // Redirect to the desired page after updating the status
    } else {
        echo '<script>alert("Failed to update payment status.")</script>';
    }
}

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

.all-table{
    position: relative;
    margin-top: 10px;
    left: 0;
}

.bookingTable {
    font-family: sans-serif;
    font-weight: 100;
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.bookingTable th, .bookingTable td {
    padding: 15px;
    background-color: rgba(255,255,255,0.2);
    text-align: center;
    color: white;
}

.bookingTable tbody:hover td {
    color: transparent;
    text-shadow: 0 0 3px #aaa;
}

.bookingTable tbody:hover tr:hover td {
    text-shadow: 0 1px 0 white;
}

.bookingTable th {
    background-color: #55608f;
}

.bookingTable tr:hover {
    background-color: rgba(255,255,255,0.3);
}

.bookingTable tr.title2 {
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
}

.button:hover {
    background-color: rgba(0, 128, 128, 0.8); 
}

.custom-select{
    border: 0;
    background: none;
    display: block;
    margin: 20px auto;
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

</style>
</head>
<body>
    <div class="menubar">
        <?php include "menubar.php"; ?>
    </div>
    <div class="all-table">
    <form action="#" method="POST">
            <select  class="custom-select" name="roomType" onchange="this.form.submit()">
                <option value="All" <?php if($roomType == 'All') { echo 'selected'; } ?>>All</option>
                <option value="Single Room" <?php if($roomType == 'Single Room') { echo 'selected'; } ?>>Single Room</option>
                <option value="Double Room" <?php if($roomType == 'Double Room') { echo 'selected'; } ?>>Double Room</option>
                <option value="Triple Room" <?php if($roomType == 'Triple Room') { echo 'selected'; } ?>>Triple Room</option>
                <option value="President Room" <?php if($roomType == 'President Room') { echo 'selected'; } ?>>President Room</option>
            </select>
    </form>

    <table class="bookingTable">
        <tr class="title2">
            <th>Booking ID</th>
            <!-- <th>Customer ID</th> -->
            <th>Customer Name</th>
            <th>Room ID</th>
            <th>Room Type</th>
            <th>Check In Date</th>
            <th>Check Out Date</th>
            <th>Days</th>
            <th>Service Charge</th>
            <th>Total</th>
            <th>Payment Status</th>
            <th align="center">Option</th>
        </tr>

        <?php
            if(mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
        ?>

        <tr>
            <td><?php echo $row['booking_id']; ?></td>
            <!-- <td><?php echo $row['customer_id']; ?></td> -->
            <td><?php echo $row['customer_name']; ?></td>
            <td><?php echo $row['room_id']; ?></td>
            <td><?php echo $row['room_type']; ?></td>
            <td><?php echo $row['checkin_date']; ?></td>
            <td><?php echo $row['checkout_date']; ?></td>
            <td><?php echo $row['day']; ?></td>
            <td><?php echo $row['service_charge']; ?></td>
            <td><?php echo $row['total_price']; ?></td>
            <td><?php echo $row['booking_status']; ?></td>
            <td align="center">
    <?php if ($row['booking_status'] == 'Pending'): ?>
        <form action="markAsPaid.php" method="POST">
            <input type="hidden" name="bookingID" value="<?php echo $row['booking_id']; ?>">
            <button type="submit" name="markPaid" class="button">Paid 💰</button>
        </form>
    <?php endif; ?>
    <a href="editBooking.php?bookingID=<?php echo $row['booking_id']; ?>" class="button">Edit 📝</a>
    <a href="deleteBooking.php?bookingID=<?php echo $row['booking_id']; ?>" class="button">Delete 🗑️</a>
</td>

        </tr>

        <?php
             }}else{
                echo '<tr><td style="padding:8pxpx; text-transform:capitalize; text-align:center;" colspan="20"; ><h2>No Bookings have been made.</h2></td></tr>';
            }
            mysqli_close($connection);
        ?>


    </table>
    </div>

</body>
</html>