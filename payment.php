<?php
session_start();
include 'dbConn.php';

$cust_id = $_SESSION['custID'];
$book_id = $_GET['bookingID'];

$query = "SELECT * FROM booking 
    INNER JOIN customer ON booking.customer_id=customer.customer_id 
    INNER JOIN room ON booking.room_id=room.room_id
    INNER JOIN hotel ON booking.hotel_id=hotel.hotel_id
    WHERE booking.customer_id= $cust_id AND booking.booking_id = $book_id";

$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

function validateForm() {
    if ($_POST['payment_method'] === 'cash') {
        return true;
    } else {
        if (empty($_POST['billing_address'])) {
            echo '<script>alert("Please enter the billing address.")</script>';
            return false;
        }
        
        if (empty($_POST['card_number'])) {
            echo '<script>alert("Please enter the card number.")</script>';
            return false;
        } elseif (strlen($_POST['card_number']) < 16) {
            echo '<script>alert("Card number must be at least 16 digits long.")</script>';
            return false;
        }

        if (empty($_POST['cvv'])) {
            echo '<script>alert("Please enter the CVV.")</script>';
            return false;
        } elseif (strlen($_POST['cvv']) < 3 || strlen($_POST['cvv']) > 4) {
            echo '<script>alert("CVV must be at least 4 digits long.")</script>';
            return false;
        }
    }

    return true;
}
    if (isset($_POST['submit'])) {
        if (validateForm()!= false) {
            $booking_id = $row['booking_id'];
            $customer_id = $row['customer_id'];
            $payment_total = $row['total_price'];
            $payment_method = $_POST['payment_method'];
            $billing_address = $_POST['billing_address'];
            $card_number = $_POST['card_number'];
            $cvv = $_POST['cvv'];

            $payment_date = date("Y-m-d H:i:s");

            
            $sql = "INSERT INTO payment (`booking_id`,`customer_id`,`payment_total`,`payment_method`,`payment_date`,`billing_address`,`card_number`,`cvv`)
                    VALUES ('$booking_id','$customer_id','$payment_total','$payment_method','$payment_date','$billing_address','$card_number','$cvv')";

            $payment_query = mysqli_query($connection, $sql);
            if($payment_query && $payment_method == 'cash'){
                $updateBookingQuery = "UPDATE booking SET booking_status = 'Pending' WHERE booking_id = '$book_id'";
                mysqli_query($connection, $updateBookingQuery); 
                
                echo '<script>alert("Please kindly pay with cash when booking into the hotel. Thank you!")</script>';
                echo "<script>window.location='viewBookingCustomer.php'</script>";
            
            }
            else if($payment_query) {
                    $updateBookingQuery = "UPDATE booking SET booking_status = 'Paid' WHERE booking_id = '$book_id'";
                    mysqli_query($connection, $updateBookingQuery); 

                echo '<script>alert("Payment Successful!")</script>';
                echo "<script>window.location='viewBookingCustomer.php'</script>";
            }
            else
                echo '<script>alert("Payment Failed!")</script>';
        
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        .menubar{
            width: 100%;
            top: 0;
            position: relative;
            left: 0;
            z-index: 9999;
            box-shadow: 0 2px 4px 0 rgba(0,0,0,.2);
        }

        .image5{
            position: relative;
            background-image: url("image/background8.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
            z-index: -1;
        }

        .bookt{
            position: absolute;
            height: 150px;
            background-color: transparent;
            font-size: 30px;
            color: white;
            z-index: 3;
            margin-top: -51%;
            margin-left: 41.5%;
        }

        .left{
            color: white;
            font-size: 25px;
            position: absolute;
            width: 40%;
            height: 390px;
            margin-left: 19%;
            margin-top: -44%;
            background-image: url('data:image;base64,<?php echo base64_encode($row['room_image']); ?>');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            z-index: 2;
        }

        .card-content{
            margin-top: 33%;
            padding-left: 20px;
            background-image: linear-gradient(
                to right,
                hsl(0, 0%, 0%) 0%,
                hsla(0, 0%, 0%, 0.964) 7.4%,
                hsla(0, 0%, 0%, 0.918) 15.3%,
                hsla(0, 0%, 0%, 0.862) 23.4%,
                hsla(0, 0%, 0%, 0.799) 31.6%,
                hsla(0, 0%, 0%, 0.73) 39.9%,
                hsla(0, 0%, 0%, 0.655) 48.2%,
                hsla(0, 0%, 0%, 0.577) 56.2%,
                hsla(0, 0%, 0%, 0.497) 64%,
                hsla(0, 0%, 0%, 0.417) 71.3%,
                hsla(0, 0%, 0%, 0.337) 78.1%,
                hsla(0, 0%, 0%, 0.259) 84.2%,
                hsla(0, 0%, 0%, 0.186) 89.6%,
                hsla(0, 0%, 0%, 0.117) 94.1%,
                hsla(0, 0%, 0%, 0.054) 97.6%,
                hsla(0, 0%, 0%, 0) 100%
            );
        }

        .right{
            color: white;
            font-size: 18px;
            position: absolute;
            padding-right: 50px;
            padding-top: 20px;
            width: 20%;
            height: 170px;
            margin-left: 24%;
            margin-top: -29%;
            background-color: rgb(0, 0, 0, 0.8);
            text-align: right;
            z-index: 1;
            border-style: solid;
            border-width: 3px;
            border-color: white;
            border-radius: 20px;
            cursor: pointer;
            transition: 1s ease-in-out;
        }

        .right:hover{
            margin-top: -19.5%;
        }

        .payment{
            width: 20%;
            height: 20%;
            position: absolute;
            background: black;
            color: white;
            margin-top: -45%;
            margin-left: 65%;
            border-radius: 20px;
            cursor: pointer;
            transition: 1s ease-in-out;
        }

        .drop{
            text-align: center;
            margin-top: 15px;
        }

        .back{
            margin-left: 5%;
            text-align: center;
            width: 120px;
            border-radius: 20px;
            transition: 0.3s ease-in;
        }

        .submit{
            margin-left: 55%;
            margin-top: -16%;
            text-align: center;
            width: 120px;
            border-radius: 20px;
            transition: 0.3s ease-in;
        }
        
        .backbtn, .paymentbtn{
            background-color: transparent;
            width: 120px;
            height: 30px;
            color: white;
            cursor: pointer;
            border: none;
            transition: 0.3s ease-in;
        }

        .back:hover{
            background-color: red;
        }

        .submit:hover{
            background-color: lightgreen;
        }

        .details{
            letter-spacing: 20px;
            margin-top: 6%;
        }

        .payment-long {
            height: 250px;
        }

        #billing_fields{
            text-align: right;
            margin-right: 10px;
            animation: swipeIn 1s forwards;
        }

        @keyframes swipeIn{
            0%{
                opacity: 0;
                margin-right: -100%;
            }
            100%{
                opacity: 1;
            }
        }


    </style>
</head>
<body>
<div class="menubar">
    <?php include "menubar.php"; ?>
</div>
<div class="image5"></div>
    <div class="bookt">
        <h2>Booking Details</h2>
    </div>
    <div class="row">
        <div class="left">
            <div class="card-content">
                <span>Customer Name:</span> <?php echo $row['customer_name']; ?></th><br>
                <span>Booking ID:</span> <?php echo $row['booking_id']; ?></th><br>
                <span>Hotel Name :</span> <?php echo $row['hotel_name']; ?></th><br>
                <span>Room Type :</span> <?php echo $row['room_type']; ?></th><br>
                <span>Room Id :</span> <?php echo $row['room_id']; ?></th><br>
            </div>
        </div>
        <div class="right">
            <span>Check In Date :</span> <?php echo $row['checkin_date']; ?></th><br>
            <span>Check In Out :</span> <?php echo $row['checkout_date']; ?></th><br>
            <span>Days :</span> <?php echo $row['day']; ?></th><br><br>
            <span>Service Tax(10%): RM</span> <?php echo $row['service_charge']; ?></span><br>
            <span>Total Price: RM</span><?php echo $row['total_price']; ?></span><br>
            <div class="details">
                DETAILS
            </div>
        </div>
    <div>
    <br><br>

    <div class="payment">
        <form action="" method="post">
            <div class="drop">
                <label for="payment_method">Payment Type: </label>
                <select id="payment_method" name="payment_method" onchange="toggleBillingFields()">
                <option value="cash">Cash</option>
                <option value="mastercard">Mastercard</option>
                <option value="visa">Visa</option>
                </select><br><br><br>
            </div>

            <div id="billing_fields" style="display: none;">
                <label for="billing_address">Billing Address :</label>
                <input type="text" id="billing_address" name="billing_address"><br><br>

                <label for="card_number">Card Number :</label>
                <input type="text" id="card_number" name="card_number"><br><br>

                <label for="cvv">CVV :</label>
                <input type="text" id="cvv" name="cvv"><br><br>
            </div>

            <div class="back">
                <input class="backbtn" type="button" value="Back" onclick="history.back()">
            </div><br>
            <div class="submit">
                <input class = "paymentbtn" type="submit" name="submit" value="Payment">
            </div>
        </form>
    </div>
</div>

<script>
    function toggleBillingFields() {
        var paymentMethod = document.getElementById("payment_method").value;
        var billingFields = document.getElementById("billing_fields");

        if (paymentMethod === "cash") {
            billingFields.style.display = "none";
            document.querySelector(".payment").classList.remove("payment-long");
        } else {
            billingFields.style.display = "block";
            document.querySelector(".payment").classList.add("payment-long");
        }
    }

</script>
</body>
</html>