<?php
session_start();
include 'dbConn.php';
$bookingID=$_GET['bookingID'];
$query = "DELETE FROM booking WHERE booking_id='$bookingID'";
if ($_SESSION['hotelID'] !== null) {
    if(mysqli_query($connection, $query)){
        mysqli_close($connection);
        echo "<script>";
        echo "alert('Room Deleted Successfully');";
        echo "window.location = 'viewBooking.php';";
        echo "</script>";
    }
    else{
        echo '<script>alert("Sorry, Something Went Wrong. Please Try Again")</script>';
        mysqli_close($connection);
    }
}
else 
    if(mysqli_query($connection, $query)){
        mysqli_close($connection);
        echo "<script>";
        echo "alert('Room Deleted Successfully');";
        echo "window.location = 'viewBookingCustomer.php';";
        echo "</script>";
    }
    else{
        echo '<script>alert("Sorry, Something Went Wrong. Please Try Again")</script>';
        mysqli_close($connection);
}
?>