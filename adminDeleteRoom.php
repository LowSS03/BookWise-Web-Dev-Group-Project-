<?php
include 'dbConn.php';
$roomID=$_GET['roomID'];
$query = "DELETE FROM room WHERE room_id='$roomID'";
if(mysqli_query($connection, $query)){
    mysqli_close($connection);
    echo "<script>";
    echo "alert('Room Deleted Successfully');";
    echo "window.location = 'adminViewRoom.php';";
    echo "</script>";
}
else{
    echo '<script>alert("Sorry, Something Went Wrong. Please Try Again")</script>';
    mysqli_close($connection);
}
?>