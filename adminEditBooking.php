<?php
session_start();
include 'dbConn.php';
$bookingID = $_GET['bookingID'];

$query = "SELECT * FROM booking 
                INNER JOIN customer ON booking.customer_id=customer.customer_id 
                INNER JOIN room ON booking.room_id=room.room_id
                INNER JOIN hotel ON booking.hotel_id=hotel.hotel_id
                WHERE booking.booking_id='$bookingID'";
                $result = mysqli_query($connection, $query);
                $row = mysqli_fetch_assoc($result); //$row[0]; $row['email']
                $count = mysqli_num_rows($result); //1 or 0


if (isset($_POST['btnUpdate'])) {

    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    // Calculate day difference
    $dayDiff = date_diff(date_create($checkin), date_create($checkout))->format('%a');
    $day = $dayDiff + 1; // Add 1 to include the checkout day

    $serviceRate = 0.1; // Service tax rate
    $service = number_format($day * $serviceRate, 2); // Calculate service charge
    $serviceTax = $_POST['serviceTax'];
    $totalPay = $_POST['totalPay'];

    // Calculate total price
    $roomPrice = $row['room_price'];
    $total = number_format($roomPrice * $day + $service, 2);

    $updateQuery = "UPDATE booking 
                    INNER JOIN customer ON booking.customer_id = customer.customer_id 
                    INNER JOIN room ON booking.room_id = room.room_id
                    INNER JOIN hotel ON booking.hotel_id = hotel.hotel_id
                    SET checkin_date='$checkin', checkout_date='$checkout', day='$day', service_charge='$serviceTax', total_price='$totalPay'
                    WHERE booking.booking_id='$bookingID'";

    if (mysqli_query($connection, $updateQuery)) {
        // Fetch the updated row from the database
        $selectQuery = "SELECT * FROM booking 
                        INNER JOIN customer ON booking.customer_id=customer.customer_id 
                        INNER JOIN room ON booking.room_id=room.room_id
                        INNER JOIN hotel ON booking.hotel_id=hotel.hotel_id
                        WHERE booking.booking_id='$bookingID'";
        $result = mysqli_query($connection, $selectQuery);
        $row = mysqli_fetch_assoc($result);

        echo "<script>";
        echo "alert('Room Updated Successfully');";
        echo "window.location = 'adminViewBooking.php';";
        echo "</script>";
    } else {
        echo 'Sorry, Something Went Wrong. Please Try Again.';
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

        * {
            box-sizing: border-box;
        }

        .img3{
            filter: blur(6px);
            -webkit-filter: blur(3px);
            background-image: url("image/background9.jpg");
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .container{
            position: absolute;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 999;
            height: 70%;
            width: 80%;
            padding: 20px;
            text-align: center;
        }

        h2{
            font-size: 50px;
        }

        .left{
            position: absolute;
            width: 45%;
            height: 80%;
            margin-left: 10%;
            /* background-image: url("image/background12.webp"); */
            background-image: url('data:image;base64,<?php echo base64_encode($row['room_image']); ?>');
            background-position: left;
            background-repeat: no-repeat;
            background-size: cover;
            box-shadow: 0 4px 4px 4px rgba(0,0,0,.2);
            z-index: 99;
            animation: flowleft 2s;
            color: white;
            font-size: 30px;
            text-align: left;
            padding: 220px 0px;
        }

        .card-content{
            padding: 0 20px;
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
            position: absolute;
            width: 40%;
            height: 65%;
            margin-left: 45%;
            margin-top: 3%;
            background-color: white;
            box-shadow: 0 2px 4px 3px rgba(0,0,0,.2);
            z-index: 9;
            border-radius: 30px;
            animation: flowright 2s;
        }

        .date{
            width: 100%;
            height: 40%;
            color: white;
            background-color: black;
            padding: 20px;
            text-align: right;
            border-top-right-radius: 20px;
        }

        .checkin{
            margin-left: 25%;
        }

        .checkout{
            margin-left: 25%;
        }

        .days{
            margin-right: 16%;
        }

        @keyframes flowleft{
            0%{
                opacity: 1;
                margin-left: 28%;
            }
            30%{
                opacity: 1;
                margin-left: 28%;
            }
            100%{
                opacity: 1;
                margin-left: 10%;
            }
        }

        @keyframes flowright{
            0%{
                opacity: 1;
                margin-left: 28%;
            }
            30%{
                opacity: 1;
                margin-left: 28%;
            }
            100%{
                opacity: 1;
                margin-left: 45%;
            }
        }

        .price{
            text-align: right;
            padding: 20px;
            font-size: 20px;
            font-family: arial;
        }

        .total{
            margin-top: 50px;
            font-size: 30px;
        }

        .btn1{
            position: absolute;
            background-color: lightgreen;
            text-align: right;
            width: 100px;
            height: 30px;
            left: 50%;
            margin-top: 26%;
            padding: 4px;
            transition: all 0.5s ease-in-out;
            animation: flowright2 2s forwards;
            cursor: pointer;
            border-radius: 20px;
            z-index: -1;
        }

        .btn2{
            position: absolute;
            background-color: red;
            text-align: right;
            width: 100px;
            height: 30px;
            left: 50%;
            margin-top: 22%;
            padding: 4px;
            transition: all 0.5s ease-in-out;
            animation: flowright2 2s forwards;
            cursor: pointer;
            border-radius: 20px;
            z-index: 1;
        }

        .btn1-style, .btn2-style{
            opacity: 0;
            transition: all 0.5s ease-in-out;
            border: none;
            background: transparent;
            color: white;
            width: 50%;
            cursor: pointer;
        }


        @keyframes flowright2{
            0%{
                opacity: 0;
                margin-left: 5%;
            }
            30%{
                opacity: 0;
                margin-left: 5%;
            }
            70%{
                opacity: 0;
                margin-left: 15%;
            }
            100%{
                opacity: 1;
                margin-left: 30%;
            }
        }

        .btn1:hover{
            width: 180px;
        }
        
        .btn1:hover .btn1-style{
            opacity: 1;
        }

        .btn2:hover{
            width: 180px;
        }

        .btn2:hover .btn2-style{
            opacity: 1;
        }



    </style>
</head>
<body>
    <div class="img3">
    </div>
    <div class="container">
        <h2>Booking Information</h2>
            <?php
                $query = "SELECT * FROM booking 
                INNER JOIN customer ON booking.customer_id=customer.customer_id 
                INNER JOIN room ON booking.room_id=room.room_id
                INNER JOIN hotel ON booking.hotel_id=hotel.hotel_id
                WHERE booking.booking_id='$bookingID'";
                $result = mysqli_query($connection, $query);
                $row = mysqli_fetch_assoc($result); //$row[0]; $row['email']
                $count = mysqli_num_rows($result); //1 or 0
                if ($count ==1){
            ?>

        <form action="#" method="POST">
            <div class="left">
            
                <div class="card-content">
                <div class="bookingid">Booking ID :  
                    <span>
                        <?php echo $row['booking_id'];?>
                        <input type="hidden" name="HotelID" value="<?php echo $row['booking_id'];?>">
                    </span>
                </div>   

                <div class="customer-name">Customer Name : 
                    <span>
                        <?php echo $row['customer_name'];?>
                    </span>
                </div>  
                
                <div class="room type">Room ID : 
                    <span>
                        <?php echo $row['room_id']; ?>
                    </span>
                </div>

                <div class="room type">Room Type : 
                    <span>
                        <?php echo $row['room_type']; ?>
                    </span>
                </div>

                <div class="room type">Room Price/Day (RM) : 
                    <span>
                        <?php echo $row['room_price']; ?>
                    </span>
                </div>
                </div>
            </div>

            <div class="right">
                <div class="date">
                    <div class="checkin">Check-In Date : 
                        <input type="date" name="checkin" id="checkin" value="<?php echo date('Y-m-d', strtotime($row['checkin_date'])); ?>">
                    </div>
                </br>

                    <div class="checkout">Check-Out Date : 
                        <input type="date" name="checkout" id="checkout" value="<?php echo date('Y-m-d', strtotime($row['checkout_date'])); ?>">
                    </div>
                    </br>

                    <div class="days">Days : 
                            <!-- <input type="text" name="day" value="<?php echo $row['day']; ?> "> -->
                            <span id="dayDisplay"></span>
                            <input type="hidden" id="day" name="day" readonly>
                    </div>
                </div>

                <div class="price">
                    <div class="tax">Service Tax:
                            <span id="serviceTaxDisplay"><?php echo $row['service_charge']; ?></span>
                            <input type="hidden" id="serviceTax" name="serviceTax" value="<?php echo $row['service_charge']; ?>" readonly>
                    </div>
                </br>

                    <div class="tax">Total Room Price:
                            <span id="totalRoomPriceDisplay"><?php echo number_format($row['room_price'] * $row['day'], 2); ?></span>
                            <input type="hidden" id="totalRoomPrice" name="totalRoomPrice" value="<?php echo $row['room_price'] * $row['day']; ?>" readonly>
                    </div>
                </br>

                    <div class="total">Total:
                            <span id="totalDisplay"><?php echo $row['total_price']; ?></span>
                            <input type="hidden" id="total" name="totalPay" value="<?php echo $row['total_price']; ?>" readonly>
                    </div>
                    </div>
                </div>
                    
                    <div class="btn1">
                        <button class="btn1-style" type="submit" value="Update" name="btnUpdate" onclick="window.location.href='adminViewBooking.php'"><b>Update </b></button>
                    </div>
                    <div class="btn2">
                        <button class="btn2-style" type="button" value="cancel" name="cancelBtn" onclick="window.location.href='adminViewBooking.php'"><b>Back </b></button><br/>
                    </div>
            </form>
        </div>

    <?php
    }
    else{
    echo 'Record Not Found.';
    }
    ?>

    <script>
                function calculateDays() {
            var checkin = new Date(document.getElementById("checkin").value);
            var checkout = new Date(document.getElementById("checkout").value);
            var timeDiff = checkout.getTime() - checkin.getTime();
            var dayDiff = Math.ceil((timeDiff / (1000 * 3600 * 24)) + 1);
            if (!isNaN(dayDiff) && dayDiff >= 0) {
                document.getElementById("day").value = dayDiff;
                document.getElementById("dayDisplay").textContent = dayDiff + (dayDiff === 1 ? " day" : " days");
            } else {
                document.getElementById("day").value = "";
                document.getElementById("dayDisplay").textContent = "";
            }
            calculateTotalRoomPrice();
        }

        function calculateTotalRoomPrice() {
            var roomPrice = <?php echo $row['room_price']; ?>;
            var day = parseInt(document.getElementById("day").value);
            var totalRoomPrice = 0;
            var serviceTaxRate = 0.1;

            if (!isNaN(day) && day >= 0) {
                totalRoomPrice = roomPrice * day;
                var formattedTotalRoomPrice = totalRoomPrice.toFixed(2);
                var serviceTax = totalRoomPrice * serviceTaxRate;
                var total = totalRoomPrice + serviceTax; // Calculate the total

                document.getElementById("totalRoomPriceDisplay").textContent = formattedTotalRoomPrice;
                document.getElementById("serviceTax").value = serviceTax.toFixed(2);
                document.getElementById("serviceTaxDisplay").textContent = serviceTax.toFixed(2);
                document.getElementById("total").value = total.toFixed(2); // Set the total value
                document.getElementById("totalDisplay").textContent = total.toFixed(2); // Display the total
            } else {
                document.getElementById("totalRoomPriceDisplay").textContent = "";
                document.getElementById("serviceTax").value = "";
                document.getElementById("serviceTaxDisplay").textContent = "";
                document.getElementById("total").value = "";
                document.getElementById("totalDisplay").textContent = ""; // Clear the total display
            }
        }

        document.getElementById("checkin").addEventListener("change", calculateDays);
        document.getElementById("checkout").addEventListener("change", calculateDays);
        document.getElementById("checkin").addEventListener("change", calculateTotalRoomPrice);
        document.getElementById("checkout").addEventListener("change", calculateTotalRoomPrice);

        // Call the functions initially to calculate and display the values
        calculateDays();
        calculateTotalRoomPrice();
    </script>

</body>
</html>
