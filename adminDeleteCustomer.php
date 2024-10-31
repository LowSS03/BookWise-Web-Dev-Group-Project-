<?php
include 'dbConn.php';
$custID=$_GET['customerID'];
$query = "DELETE FROM customer WHERE customer_id='$custID'";
if(mysqli_query($connection, $query)){
    mysqli_close($connection);
    echo "<script>";
    echo "alert('Account Deleted Successfully');";
    echo "window.location = 'adminViewCustomer.php';";
    echo "</script>";
}
else{
    echo '<script>alert("Sorry, Something Went Wrong. Please Try Again")</script>';
    mysqli_close($connection);
}
?>