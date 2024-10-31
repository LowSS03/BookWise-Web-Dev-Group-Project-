<?php
session_start();
unset($_SESSION["custID"]);
unset($_SESSION["custEmail"]);
unset($_SESSION["custName"]);
unset($_SESSION["hotelID"]);
unset($_SESSION["hotelEmail"]);
unset($_SESSION["hotelName"]);
unset($_SESSION["admin"]);
header("Location: homepage.php");
?>