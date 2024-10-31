<?php
include 'dbConn.php';
$hotelID=$_GET['hotelID'];
$query = "DELETE FROM hotel WHERE hotel_id='$hotelID'";
if(mysqli_query($connection, $query)){
    mysqli_close($connection);
    echo "<script>";
    echo "alert('Account Deleted Successfully');";
    echo "window.location = 'adminViewHotel.php';";
    echo "</script>";
}
else{
    echo '<script>alert("Sorry, Something Went Wrong. Please Try Again")</script>';
    mysqli_close($connection);
}
?>